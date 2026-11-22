<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login · DashStore</title>

    <link href="{{ asset('panelassets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800" rel="stylesheet">
    <link href="{{ asset('panelassets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-store fa-3x text-primary mb-3"></i>
                            <h1 class="h4 text-gray-900">DashStore Admin</h1>
                            <p class="small text-muted mb-0">Sign in to manage your store</p>
                        </div>

                        <form method="POST" action="{{ route('admin.login') }}" class="user">
                            @csrf

                            <div class="form-group">
                                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                    autocomplete="username" placeholder="Email address" aria-label="Email address"
                                    class="form-control form-control-user @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback d-block text-center">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" required autocomplete="current-password"
                                    placeholder="Password" aria-label="Password"
                                    class="form-control form-control-user @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback d-block text-center">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" name="remember" value="1" class="custom-control-input"
                                        id="remember">
                                    <label class="custom-control-label" for="remember">Remember me</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                        </form>

                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{ route('home') }}">&larr; Back to store</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
