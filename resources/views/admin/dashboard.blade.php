@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h3 class="fw-bold fs-4 mb-3">Admin Dashboard</h3>
        <div class="row">
            <div class="col-12 col-md-4 ">
                <div class="card border-0">
                    <div class="card-body py-4">
                        <h5 class="mb-2 fw-bold">
                            Total Student
                        </h5>
                        <p class="mb-2 fw-bold">
                            100 Member
                        </p>
                        <div class="mb-0">
                            <span class="badge text-success me-2">
                                +9.0%
                            </span>
                            <span class=" fw-bold">
                                Since Last Month
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 ">
                <div class="card  border-0">
                    <div class="card-body py-4">
                        <h5 class="mb-2 fw-bold">
                            Total Course
                        </h5>
                        <p class="mb-2 fw-bold">
                            10 Course
                        </p>
                        <div class="mb-0">
                            <span class="badge text-success me-2">
                                +10.0%
                            </span>
                            <span class="fw-bold">
                                Since Last Month
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 ">
                <div class="card border-0">
                    <div class="card-body py-4">
                        <h5 class="mb-2 fw-bold">
                            Total Contest
                        </h5>
                        <p class="mb-2 fw-bold">
                            8 Contest
                        </p>
                        <div class="mb-0">
                            <span class="badge text-success me-2">
                                +100.0%
                            </span>
                            <span class="fw-bold">
                                Since Last Month
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="fw-bold fs-4 my-3">Avg. Agent Earnings
        </h3>
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr class="highlight">
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">1</td>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <td scope="row">2</td>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <td scope="row">3</td>
                            <td colspan="2">Larry the Bird</td>
                            <td>@twitter</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection