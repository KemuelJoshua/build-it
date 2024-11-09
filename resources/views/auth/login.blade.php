@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center mt-5">
        <div class="col-12 col-md-5">
            <div class="card shadow p-3" style="border-radius: 20px">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h2 class="text-uppercase fw-bold">Sign In</h2>
                    <p>Please sign in to continue...</p>
                    <hr>
                </div>
                <div class="card-body pb-4">
                    <form method="post" action="{{ route('login') }}">
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
                        <div class="mb-4">
                            <label style="font-size: 12px" class="text-uppercase fw-bold mb-2">Password</label>
                            <input type="password" name="password" id="password" class="form-control py-3" placeholder="••••••••">
                            @error('password')
                                <span class="text-danger text-uppercase mt-1" style="font-size: 11px" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <a href="{{route('password.request')}}" class="nav-link text-uppercase mt-2 text-decoration-underline fw-medium" style="font-size:12px">Forgot Password</a>
                        </div>
                        <button type="submit" class="btn btn-primary px-5 py-3 text-uppercase fw-bold w-100">Login</button>
                        <div class="w-100 m-auto py-3 text-uppercase fw-medium text-center">
                            or
                        </div>
                        <a href="{{route('register')}}" class="btn btn-outline-primary px-5 py-3 text-uppercase fw-bold w-100">Register</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
