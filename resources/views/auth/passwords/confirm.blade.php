@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center mt-5">
        <div class="col-12 col-md-5">
            <div class="card shadow p-3" style="border-radius: 20px">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h2 class="text-uppercase fw-bold">Password Reset</h2>
                    <p>Please sign in to continue...</p>
                    <hr>
                </div>
                <div class="card-body pb-4">
                    @if (session('status'))
                        <div class="alert alert-info text-center" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="post" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-4">
                            <label style="font-size: 12px" class="text-uppercase fw-bold mb-2">Email</label>
                            <input type="text" name="email" id="email" class="form-control py-3" placeholder="user@example.com">
                            @error('email')
                                <span class="text-danger text-uppercase mt-1" style="font-size: 11px" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary px-5 py-3 text-uppercase fw-bold w-100">Send Request</button>
                        <div class="w-100 m-auto py-3 text-uppercase fw-medium text-center">
                            or
                        </div>
                        <a href="{{route('login')}}" class="btn btn-outline-primary px-5 py-3 text-uppercase fw-bold w-100">Login</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <div class="card-body">
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
