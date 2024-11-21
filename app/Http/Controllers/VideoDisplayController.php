<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoDisplayController extends Controller
{
    public function show($courseId)
    {
        // Lấy khóa học và video liên quan
        $course = Course::findOrFail($courseId);
        $videos = Video::where('course_id', $courseId)->get();

        return view('client.videos.show', compact('course', 'videos'));
    }
}

