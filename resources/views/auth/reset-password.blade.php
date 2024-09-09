@extends('admin.layouts.auth')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>News Portal</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address or Username-->
                    <div class="input-group mb-3">
                        <div class="col-12 mt-3">
                            <label for="input_type" class="form-label"><strong>Email / Username:</strong></label>
                            <input type="text" class="form-control" id="input_type" name="input_type"
                                value="{{ old('input_type', $request->input_type) }}" required autofocus autocomplete="name" />
                            @error('email')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                            @error('name')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password-->
                        <div class="col-12 mt-3">
                            <label for="password" class="form-label"><strong>Password:</strong></label>
                            <input type="password" class="form-control" id="password" name="password"
                            required autocomplete="new-password" />
                            @error('password')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password-->
                        <div class="col-12 mt-3">
                            <label for="password_confirmation" class="form-label"><strong>Confirm Password:</strong></label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                required autocomplete="new-password" />
                            @error('password_confirmation')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">{{ __('Reset Password') }}</button>
                            </div>
                        </div> <!-- /.col -->
                    </div>

                </form>
            </div> <!-- /.login-card-body -->
        </div>
    </div> <!-- /.login-box -->
@endsection



