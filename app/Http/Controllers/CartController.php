<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseRegistration;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $userId = Auth::id();

        // Lấy danh sách khóa học đã được đăng ký
        $registeredCourses = CourseRegistration::where('user_id', $userId)->pluck('course_id');

        // Lấy các mục trong giỏ hàng không thuộc các khóa học đã đăng ký
        $cartItems = CartItem::where('user_id', $userId)
            ->whereNotIn('course_id', $registeredCourses)
            ->with('course')
            ->get();

        return view('client.cart.index', compact('cartItems'));
    }


    // Thêm khóa học vào giỏ hàng
    public function addToCart(Request $request, $courseId)
    {
        $userId = Auth::id();

        // Kiểm tra khóa học đã được đăng ký hay chưa
        $isRegistered = CourseRegistration::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->exists();

        if ($isRegistered) {
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
    public function checkout()
    {
        $cartItems = CartItem::with('course')
            ->where('user_id', Auth::id())
            ->get();

        foreach ($cartItems as $item) {
            // Tạo đơn đăng ký khóa học
            \App\Models\CourseRegistration::create([
                'user_id' => Auth::id(),
                'course_id' => $item->course_id,
                'status' => 'paid',
                'amount' => $item->course->price ?? 0,
            ]);
        }

        // Xóa giỏ hàng sau khi thanh toán
        CartItem::where('user_id', Auth::id())->delete();

        return redirect()->route('courses.my_courses')->with('success', 'Thanh toán thành công.');
    }
}
