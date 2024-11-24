@extends('layouts.client')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center"><i class="bi bi-cart3"></i> Giỏ hàng của bạn</h1>
    @if($cartItems->isEmpty())
        <div class="alert alert-warning text-center">Giỏ hàng của bạn trống.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Khóa học</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td class="text-center">
                                <img src="{{ asset('public/storage/' . $item->course->image) }}"
                                    alt="{{ $item->course->courseName }}"
                                    style="width: 100px; height: auto; object-fit: cover; border-radius: 5px;">
                            </td>
                            <td>
                                <strong>{{ $item->course->courseName }}</strong>
                                <p class="text-muted small">{{ Str::limit($item->course->description, 50) }}</p>
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-center text-danger fw-bold">
                                {{ number_format($item->course->price ?? 0, 0, ',', '.') }} VND
                            </td>
                            <td class="text-center">
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <h5 class="me-3">
                    Tổng tiền: <strong class="text-danger">{{ number_format($totalAmount, 0, ',', '.') }} VND</strong>
                </h5>
                <button class="btn btn-success btn-lg">
                    <i class="bi bi-credit-card"></i> Thanh toán
                </button>
            </form>
        </div>
    @endif
</div>
@endsection
