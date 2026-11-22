@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    @php
        $cards = [
            ['label' => 'Revenue', 'value' => '$' . number_format($stats['revenue'], 2), 'icon' => 'dollar-sign', 'color' => 'success'],
            ['label' => 'Orders', 'value' => number_format($stats['orders']), 'icon' => 'receipt', 'color' => 'primary'],
            ['label' => 'Pending orders', 'value' => number_format($stats['pending']), 'icon' => 'hourglass-half', 'color' => 'warning'],
            ['label' => 'Customers', 'value' => number_format($stats['customers']), 'icon' => 'users', 'color' => 'info'],
        ];
    @endphp

    <div class="row">
        @foreach ($cards as $card)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-{{ $card['color'] }} shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-{{ $card['color'] }} text-uppercase mb-1">
                                    {{ $card['label'] }}
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $card['value'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-{{ $card['icon'] }} fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Latest orders</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th class="text-right">Total</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestOrders as $order)
                                <tr>
                                    <td class="font-weight-bold">{{ $order->number }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $order->status->color() }}">
                                            {{ $order->status->label() }}
                                        </span>
                                    </td>
                                    <td class="text-right">${{ number_format($order->total, 2) }}</td>
                                    <td class="text-muted small">{{ $order->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Catalog</h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        Products <strong>{{ number_format($stats['products']) }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        Out of stock
                        <strong class="{{ $stats['outOfStock'] ? 'text-danger' : '' }}">
                            {{ number_format($stats['outOfStock']) }}
                        </strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
