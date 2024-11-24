<?php

namespace App\Http\Controllers;

use App\Models\CourseRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class PaymentController extends Controller
{
    // Tạo thanh toán cho một khóa học
    public function createPayment(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        // Kiểm tra nếu đã tồn tại giao dịch 'pending'
        $registration = CourseRegistration::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->where('status', 'pending')
            ->first();

        if (!$registration) {
            // Nếu chưa có giao dịch 'pending', tạo giao dịch mới
            $registration = CourseRegistration::create([
                'user_id' => Auth::id(),
                'course_id' => $courseId,
                'amount' => $course->price,
                'status' => 'pending',
                'transaction_id' => time(), // Tạo transaction_id duy nhất
            ]);
        }

        // Cấu hình VNPAY
        $vnp_TmnCode = env('VNP_TMN_CODE');
        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = route('payment.return');

        $vnp_TxnRef = $registration->id; // Sử dụng ID giao dịch đã tồn tại
        $vnp_OrderInfo = 'Thanh toán khóa học: ' . $course->courseName;
        $vnp_Amount = $course->price * 100; // Giá trị thanh toán (VNĐ * 100)
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


    // Xử lý trả về từ VNPAY
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
            $registrationId = $inputData['vnp_TxnRef'];
            $registration = CourseRegistration::find($registrationId);

            if (!$registration || $registration->status !== 'pending') {
                return redirect()->route('courses.index')->with('error', 'Giao dịch không hợp lệ hoặc đã được xử lý.');
            }

            if ($inputData['vnp_ResponseCode'] == '00') {
                // Thanh toán thành công: Cập nhật trạng thái
                $registration->update(['status' => 'paid']);
                return redirect()->route('courses.my_courses')->with('success', 'Thanh toán thành công!');
            } else {
                // Thanh toán thất bại
                $registration->update(['status' => 'cancelled']);
                return redirect()->route('courses.index', $registration->course_id)->with('error', 'Thanh toán thất bại!');
            }
        } else {
            return redirect()->route('courses.index')->with('error', 'Dữ liệu không hợp lệ!');
        }
    }

}
