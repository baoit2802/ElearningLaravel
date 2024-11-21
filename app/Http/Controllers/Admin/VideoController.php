<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Course;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::with('course')->get();
        return view('admin.videos.index', compact('videos'))->with('success','Danh sách video bài giảng');
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.videos.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
        ]);

        Video::create($request->all());
        return redirect()->route('admin.videos.index')->with('success', 'Video được thêm thành công!');
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);
        $courses = Course::all();
        return view('admin.videos.edit', compact('video', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
        ]);

        $video = Video::findOrFail($id);
        $video->update($request->all());
        return redirect()->route('admin.videos.index')->with('success', 'Video được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video đã được xóa!');
    }
}
