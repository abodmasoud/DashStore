@extends('layouts.store')

@section('title', 'Create account')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <h1 class="h4 fw-bold mb-1">Create your account</h1>
                        <p class="text-muted mb-4">It only takes a minute.</p>

                        <form method="POST" action="{{ route('register') }}" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Full name</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                    autocomplete="name" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-sm-7 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                        autocomplete="email" class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-5 mb-3">
                                    <label for="phone" class="form-label">Phone <span class="text-muted small">(optional)</span></label>
                                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                                        autocomplete="tel" class="form-control @error('phone') is-invalid @enderror">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input id="password" type="password" name="password" required
                                        autocomplete="new-password"
                                        class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mb-4">
                                    <label for="password_confirmation" class="form-label">Confirm password</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                        required autocomplete="new-password" class="form-control">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Create account</button>
                        </form>

                        <p class="text-center small text-muted mt-4 mb-0">
                            Already have an account? <a href="{{ route('login') }}">Log in</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
