@extends('admin.layouts.auth')

@section('content')

    <body class="register-page bg-body-secondary">
        <div class="register-box">
            <div class="register-logo">
                <a href="#"><b>News Portal</b></a>
            </div>

            <div class="card">
                <div class="card-body register-card-body">
                    <p class="register-box-msg">Register a new membership</p>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Full Name -->
                        <div class="input-group mb-3">
                            <input id="name" type="text" class="form-control" placeholder="Full Name" name="name"
                                value="{{ old('name') }}" required autofocus autocomplete="name">
                            <div class="input-group-text">
                                <span class="bi bi-person"></span>
                            </div>
                        </div>
                        @error('name')
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        @enderror

                        <!-- Email Address -->
                        <div class="input-group mb-3">
                            <input id="email" type="email" class="form-control" placeholder="Email" name="email"
                                value="{{ old('email') }}" required autocomplete="username">
                            <div class="input-group-text">
                                <span class="bi bi-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        @enderror

                        <!-- Password -->
                        <div class="input-group mb-3">
                            <input id="password" type="password" class="form-control" placeholder="Password"
                                name="password" required autocomplete="new-password">
                            <div class="input-group-text">
                                <span class="bi bi-lock-fill"></span>
                            </div>
                        </div>
                        @error('password')
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        @enderror

                        <!-- Confirm Password -->
                        <div class="input-group mb-3">
                            <input id="password_confirmation" type="password" class="form-control"
                                placeholder="Confirm Password" name="password_confirmation" required
                                autocomplete="new-password">
                            <div class="input-group-text">
                                <span class="bi bi-lock-fill"></span>
                            </div>
                        </div>
                        @error('password_confirmation')
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        @enderror

                        <!-- Checkbox -->
                        <div class="row">
                            <div class="col-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        I agree to the <a href="#">terms</a>
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                            </div> <!-- /.col -->
                        </div> <!-- /.row -->

                    </form>

                    {{-- <div class="social-auth-links text-center mb-3 d-grid gap-2">
                        <p>- OR -</p>
                        <a href="#" class="btn btn-primary">
                            <i class="bi bi-facebook me-2"></i> Sign up using Facebook
                        </a>
                        <a href="#" class="btn btn-danger">
                            <i class="bi bi-google me-2"></i> Sign up using Google+
                        </a>
                    </div>  --}}

                    <p class="mb-0">
                        <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
@endsection
