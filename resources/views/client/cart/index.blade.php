@extends('layouts.client')

@section('content')
<div class="container mt-4">
    <h1>Giỏ hàng</h1>
    @if($cartItems->isEmpty())
        <p>Giỏ hàng của bạn trống.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Khóa học</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                    <tr>
                        <td>{{ $item->course->courseName }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->course->price ?? 0, 2) }} VND</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <button class="btn btn-success">Thanh toán</button>
        </form>
    @endif
</div>
@endsection
