@extends('admin.layouts.auth')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>News Portal</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ __('Forgot your password? No problem. Just let us know your email address or username and we will email you a password reset link that will allow you to choose a new one.') }}</p>

                @include('admin.message')

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address or Username-->
                    <div class="input-group mb-3">
                        <div class="col-12">
                            <label for="input_type" class="form-label"><strong>Email / Username:</strong></label>
                            <input type="text" class="form-control" id="input_type" name="input_type"
                            value="{{ old('input_type') }}" required autofocus />
                            @error('email')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                            @error('name')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">{{ __('Email Password Reset Link') }}</button>
                            </div>
                        </div> <!-- /.col -->
                    </div>

                </form>

                {{-- Back to Login --}}
                <p class="mt-4">
                    <a href="{{ route('login') }}" class="text-center">Back to Login</a>
                </p>
            </div> <!-- /.login-card-body -->
        </div>
    </div> <!-- /.login-box -->
@endsection
