@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h3 class="fw-bold fs-4 mb-3">Admin Dashboard</h3>
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card border-0">
                    <div class="card-body py-4">
                        <h5 class="mb-2 fw-bold">Total Users</h5>
                        <p class="mb-2 fw-bold">{{ $totalUsers }} Member</p>
                        <div class="mb-0">
                            <span class="badge text-success me-2">+9.0%</span>
                            <span class="fw-bold">Since Last Month</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0">
                    <div class="card-body py-4">
                        <h5 class="mb-2 fw-bold">Total Courses</h5>
                        <p class="mb-2 fw-bold">{{ $totalCourses }} Course</p>
                        <div class="mb-0">
                            <span class="badge text-success me-2">+10.0%</span>
                            <span class="fw-bold">Since Last Month</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0">
                    <div class="card-body py-4">
                        <h5 class="mb-2 fw-bold">Total Contests</h5>
                        <p class="mb-2 fw-bold">{{ $totalExams }} Contest</p>
                        <div class="mb-0">
                            <span class="badge text-success me-2">+100.0%</span>
                            <span class="fw-bold">Since Last Month</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="fw-bold fs-4 my-3">Total Earnings</h3>
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body py-4">
                        <h5 class="mb-2 fw-bold">Total Earnings</h5>
                        <p class="mb-2 fw-bold">${{ number_format($totalEarnings, 2) }}</p>
                        <div class="mb-0">
                            <span class="badge text-success me-2">+15.0%</span>
                            <span class="fw-bold">Since Last Month</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
