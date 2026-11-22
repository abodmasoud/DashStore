@extends('layouts.store')

@section('content')
    <div class="container">
        <section class="p-5 mb-5 bg-primary text-white rounded-4 shadow-sm">
            <div class="col-lg-7">
                <h1 class="display-5 fw-bold">Tech you'll love, prices you'll like.</h1>
                <p class="lead opacity-75 mb-0">Phones, laptops, audio and accessories from the brands you trust.</p>
            </div>
        </section>

        <div class="d-flex justify-content-between align-items-end mb-3">
            <h2 class="h4 fw-bold mb-0">Featured products</h2>
        </div>

        <div class="row g-4">
            @forelse ($featured as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm product-card">
                        <div class="product-thumb d-flex align-items-center justify-content-center rounded-top position-relative">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-100 h-100 object-fit-cover rounded-top">
                            @else
                                <i class="bi bi-image text-secondary fs-1 opacity-50"></i>
                            @endif
                            @if ($product->has_discount)
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                    -{{ $product->discount_percent }}%
                                </span>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="small text-muted">{{ $product->category->name }}</div>
                            <h3 class="h6 fw-semibold mb-2">{{ $product->name }}</h3>
                            <div>
                                <span class="fw-bold">${{ number_format($product->final_price, 2) }}</span>
                                @if ($product->has_discount)
                                    <del class="small text-muted ms-1">${{ number_format($product->price, 2) }}</del>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center text-muted py-5 bg-white rounded-3">
                        No featured products yet. Run <code>php artisan db:seed</code> to load demo data.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
