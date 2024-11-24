<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Course;
use App\Models\CourseRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $userId = Auth::id();

        // Lấy danh sách các khóa học trong giỏ hàng (chưa thanh toán)
        $cartItems = CartItem::where('user_id', $userId)
            ->with([
                'course' => function ($query) {
                    $query->select('id', 'courseName', 'price', 'image', 'description'); // Chỉ lấy những thông tin cần thiết
                }
            ])
            ->get();

        // Tính tổng giá trị giỏ hàng
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->course->price ?? 0;
        });

        return view('client.cart.index', compact('cartItems', 'totalAmount'));
    }

    // Thêm khóa học vào giỏ hàng
    public function addToCart(Request $request, $courseId)
    {
        $userId = Auth::id();

        // Kiểm tra khóa học đã được đăng ký hay chưa
        $isPaid = CourseRegistration::where('user_id', $userId)
            ->where('course_id', $courseId)->where('status', 'paid')
            ->exists();

            if ($isPaid) {
                return redirect()->route('cart.index')->with('error', 'Khóa học này đã được đăng ký.');
            }

        // Kiểm tra nếu khóa học đã có trong giỏ hàng
        $cartItem = CartItem::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->first();

        if ($cartItem) {
            return redirect()->route('cart.index')->with('error', 'Khóa học đã có trong giỏ hàng.');
        }

        // Thêm khóa học vào giỏ hàng
        CartItem::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'quantity' => 1,
            'amount' => Course::findOrFail($courseId)->price,
        ]);

        return redirect()->route('cart.index')->with('success', 'Khóa học đã được thêm vào giỏ hàng.');
    }

    // Xóa khóa học khỏi giỏ hàng
    public function removeFromCart($id)
    {
        $cartItem = CartItem::findOrFail($id);

        if ($cartItem->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Khóa học đã được xóa khỏi giỏ hàng.');
    }

    // Thanh toán
    public function checkout(Request $request)
    {
        $userId = Auth::id();

        // Xóa các bản ghi 'pending' trước khi xử lý giỏ hàng
        CourseRegistration::where('user_id', $userId)
        ->where('status', 'pending')
        ->delete();

        // Lấy các mục trong giỏ hàng
        $cartItems = CartItem::where('user_id', $userId)->with('course')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Kiểm tra xem có khóa học nào trong giỏ hàng đã được thanh toán hay không
        $paidCourses = CourseRegistration::where('user_id', $userId)
            ->where('status', 'paid')
            ->pluck('course_id')
            ->toArray();

        $cartItems = $cartItems->filter(function ($item) use ($paidCourses) {
            return !in_array($item->course_id, $paidCourses); // Loại bỏ khóa học đã thanh toán
        });

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tất cả các khóa học trong giỏ hàng đã được thanh toán.');
        }

        // Tạo các đăng ký với trạng thái 'pending'
        $transactionId = time(); // Sử dụng timestamp làm mã giao dịch duy nhất
        foreach ($cartItems as $item) {
            CourseRegistration::updateOrCreate(
                [
                    'user_id' => $userId,
                    'course_id' => $item->course_id,
                    'status' => 'pending',
                ],
                [
                    'amount' => $item->course->price ?? 0,
                    'transaction_id' => $transactionId,
                ]
            );
        }

        // Chuẩn bị dữ liệu gửi tới VNPAY
        $vnp_TmnCode = env('VNP_TMN_CODE');
        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = route('cart.returnPayment');

        $vnp_TxnRef = $transactionId;
        $vnp_OrderInfo = 'Thanh toán giỏ hàng';
        $vnp_Amount = $cartItems->sum(function ($item) {
            return $item->course->price ?? 0;
        }) * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $request->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $query = http_build_query($inputData);
        $vnp_Url = $vnp_Url . "?" . $query;

        if ($vnp_HashSecret) {
            $vnpSecureHash = hash_hmac('sha512', $query, $vnp_HashSecret);
            $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
    }

    public function returnPayment(Request $request)
    {
        $vnp_HashSecret = env('VNP_HASH_SECRET');

        $inputData = [];
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $hashData = http_build_query($inputData);
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash == $vnp_SecureHash) {
            $transactionId = $inputData['vnp_TxnRef'];

            $registrations = CourseRegistration::where('transaction_id', $transactionId)
                ->where('user_id', Auth::id())
                ->get();

            if ($registrations->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Không tìm thấy giao dịch hợp lệ.');
            }

            if ($inputData['vnp_ResponseCode'] == '00') {
                foreach ($registrations as $registration) {
                    $registration->update(['status' => 'paid']);
                    CartItem::where('user_id', Auth::id())
                        ->where('course_id', $registration->course_id)
                        ->delete();
                }

                return redirect()->route('courses.my_courses')->with('success', 'Thanh toán thành công!');
            } else {
                return redirect()->route('cart.index')->with('error', 'Thanh toán thất bại!');
            }
        } else {
            return redirect()->route('cart.index')->with('error', 'Dữ liệu không hợp lệ!');
        }
    }
}
