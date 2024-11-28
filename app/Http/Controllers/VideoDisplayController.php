<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoDisplayController extends Controller
{
    public function show($courseId)
    {
        // Lấy khóa học
        $course = Course::findOrFail($courseId);

        // Lấy danh sách video và đánh giá liên quan
        $videos = Video::with(['reviews.user'])->where('course_id', $courseId)->get();

        return view('client.videos.show', compact('course', 'videos'));
    }

    public function getReviews($videoId)
    {
        $video = Video::with('reviews.user')->findOrFail($videoId);
        return response()->json($video->reviews);
    }

}
