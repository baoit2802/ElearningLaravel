<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseRegistrationController extends Controller
{
    public function show($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('client.courses.show', compact('course'));
    }

    // Xử lý đăng ký khóa học
    public function register(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        if (CourseRegistration::where('user_id', Auth::id())->where('course_id', $courseId)->exists()) {
            return redirect()->back()->with('error', 'Bạn đã đăng ký khóa học này.');
        }

        // Kiểm tra nếu khóa học miễn phí
        if ($course->price == 0) {
            CourseRegistration::create([
                'user_id' => Auth::id(),
                'course_id' => $course->id,
                'amount' => 0,
                'status' => 'paid',
            ]);

            return redirect()->route('courses.my_courses')->with('success', 'Bạn đã đăng ký khóa học thành công!');
        }

        // Đối với khóa học có giá, chuyển hướng đến VNPAY
        $registration = CourseRegistration::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'amount' => $course->price,
            'status' => 'pending',
        ]);

        return redirect()->route('payment.create', ['id' => $registration->id]);
    }


    // Trang thanh toán
    public function payment($registrationId)
    {
        $registration = CourseRegistration::with('course')->findOrFail($registrationId);
        return view('client.courses.payment', compact('registration'));
    }

    // Xử lý thanh toán
    public function processPayment(Request $request, $registrationId)
    {
        $registration = CourseRegistration::findOrFail($registrationId);

        // Xử lý thanh toán tại đây (giả sử thanh toán thành công)
        $registration->update(['status' => 'paid']);

        return redirect('/courses')->with('success', 'Khóa học đã được đăng ký thành công!');

    }
    public function myCourses()
    {
        $user = Auth::user();

        // Lấy danh sách khóa học đã đăng ký
        $courses = Course::whereIn('id', function ($query) use ($user) {
            $query->select('course_id')
                ->from('course_registrations')
                ->where('user_id', $user->id)
                ->where('status', 'paid');// Chi lay trang thai paid
        })->get();

        return view('client.courses.my_courses', compact('courses'));
    }


    //Quản lý đăng ký khóa học
    public function adminIndex()
    {
        $registrations = CourseRegistration::with(['user', 'course'])->get();
        return view('admin.registrations.index', compact('registrations'));
    }
    public function destroy($id)
    {
        // Tìm việc đăng ký khóa học theo ID
        $registration = CourseRegistration::findOrFail($id);

        // Xóa việc đăng ký khóa học
        $registration->delete();

        // Chuyển hướng lại trang quản lý với thông báo thành công
        return redirect()->route('admin.registrations.index')->with('success', 'Việc đăng ký khóa học đã được xóa thành công!');
    }

}

