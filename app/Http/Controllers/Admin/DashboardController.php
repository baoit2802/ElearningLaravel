<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Exam;
use Illuminate\Http\Request;
use App\Models\User;


class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('is_admin', false)->count();
        $totalCourses = Course::count();
        $totalExams = Exam::count();
        $totalEarnings = CourseRegistration::sum('amount');

        return view('admin.dashboard', compact('totalUsers', 'totalCourses', 'totalExams', 'totalEarnings'));
    }
}
