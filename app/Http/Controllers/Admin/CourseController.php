<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\CourseRegistration;


class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->is_admin) {
            // Quản trị viên: Hiển thị danh sách tất cả khóa học
            return view('admin.courses.index', ['courses' => Course::all()]);
        }

        // Người dùng: Hiển thị khóa học chưa đăng ký
        $registeredCourses = CourseRegistration::where('user_id', $user->id)
            ->where('status', 'paid')->pluck('course_id');
        $courses = Course::whereNotIn('id', $registeredCourses)->get();

        return view('client.courses.index', compact('courses'))->with('success', 'Danh sách các khóa học');
    }

    public function adminHome(){
        $courses = Course::all();
        return view('client.courses.index', compact('courses'))->with('success','Chuyển đến trang người dùng thành công');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'courseName' => 'required|string|max:255',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
        ]);

        // Lấy dữ liệu từ form
        $data = $request->only(['courseName', 'description', 'details', 'price']);

        // Kiểm tra nếu có tệp hình ảnh
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $file = $request->file('image');
            $path = $file->store('courses', 'public');
            $data['image'] = $path;
        }

        // Tạo mới khóa học
        Course::create($data);

        return redirect()->route('admin.courses.index')->with('success', 'Khóa học đã được thêm thành công!');
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Auth::user();

        // Kiểm tra trạng thái đăng ký
        $isRegistered = CourseRegistration::where('user_id', $user->id)
            ->where('course_id', $id)
            ->exists();

        if ($isRegistered) {
            return redirect()->route('courses.my_courses');
        }

        $course = Course::findOrFail($id);

        return view('client.courses.show', compact('course'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        // Xác thực dữ liệu
        $request->validate([
            'courseName' => 'required|string|max:255',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
        ]);


        $data = $request->only(['courseName', 'description', 'details', 'price']);
        // Kiểm tra nếu có tệp hình ảnh
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            // Xóa ảnh cũ nếu có
            if ($course->image && Storage::exists('public/' . $course->image)) {
                Storage::delete('public/' . $course->image);
            }

            $file = $request->file('image');
            $path = $file->store('courses', 'public');
            $data['image'] = $path;
        }

        // Cập nhật khóa học
        $course->update($data);

        return redirect()->route('admin.courses.index')->with('success', 'Khóa học đã được cập nhật!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        // Tìm kiếm các khóa học dựa trên tên hoặc mô tả
        $courses = Course::where('courseName', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        // Trả về view hiển thị kết quả tìm kiếm
        return view('client.courses.search', compact('courses', 'query'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Khóa học đã được xóa!');
    }
}
