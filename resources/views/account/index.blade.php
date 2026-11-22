@extends('layouts.store')

@section('title', 'My account')

@section('content')
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:72px;height:72px">
                            <i class="bi bi-person fs-2"></i>
                        </div>
                        <h1 class="h5 fw-bold mb-0">{{ $user->name }}</h1>
                        <div class="text-muted small">{{ $user->email }}</div>
                        @if ($user->phone)
                            <div class="text-muted small">{{ $user->phone }}</div>
                        @endif
                        <div class="text-muted small mt-2">Member since {{ $user->created_at->format('M Y') }}</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h2 class="h6 fw-bold mb-0">Recent orders</h2>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Status</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td class="fw-semibold">{{ $order->number }}</td>
                                        <td class="text-muted small">{{ $order->created_at->format('M j, Y') }}</td>
                                        <td>{{ $order->items_count }}</td>
                                        <td>
                                            <span class="badge text-bg-{{ $order->status->color() }}">
                                                {{ $order->status->label() }}
                                            </span>
                                        </td>
                                        <td class="text-end">${{ number_format($order->total, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">
                                            You haven't placed any orders yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
