@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center mt-5 pb-5">
        <div class="col-12 col-md-6">
            <div class="card shadow p-3" style="border-radius: 20px">
                <div class="card-header bg-transparent border-0 pt-4">
                    <h2 class="text-uppercase fw-bold">Sign up</h2>
                    <p>Please Fill up the form to register.</p>
                    <hr>
                </div>
                <div class="card-body pb-4">
                    <form method="post" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-4">
                                    <label style="font-size: 12px" class="text-uppercase fw-bold mb-2">First Name</label>
                                    <input type="text" name="firstname" id="firstname" class="form-control py-3 text-uppercase" value="{{old('firstname')}}" placeholder="First Name">
                                    @error('firstname')
                                    <span class="text-danger text-uppercase mt-1" style="font-size: 11px" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-4">
                                    <label style="font-size: 12px" class="text-uppercase fw-bold mb-2">Last Name</label>
                                    <input type="text" name="lastname" id="lastname" class="form-control py-3 text-uppercase" value="{{old('lastname')}}" placeholder="Last Name">
                                    @error('lastname')
                                        <span class="text-danger text-uppercase mt-1" style="font-size: 11px" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-4">
                                    <label style="font-size: 12px" class="text-uppercase fw-bold mb-2">Email</label>
                                    <input type="text" name="email" id="email" class="form-control py-3 text-uppercase" value="{{old('email')}}" placeholder="user@example.com">
                                    @error('email')
                                        <span class="text-danger text-uppercase mt-1" style="font-size: 11px" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-4">
                                    <label style="font-size: 12px" class="text-uppercase fw-bold mb-2">Password</label>
                                    <input type="password" name="password" id="password" class="form-control py-3 text-uppercase" value="{{old('password')}}" placeholder="••••••••">
                                    @error('password')
                                        <span class="text-danger text-uppercase mt-1" style="font-size: 11px" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-4">
                                    <label style="font-size: 12px" class="text-uppercase fw-bold mb-2">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control py-3 text-uppercase" value="{{old('confirm_password')}}" placeholder="••••••••">
                                    @error('confirm_password')
                                        <span class="text-danger text-uppercase mt-1" style="font-size: 11px" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary px-5 py-3 text-uppercase fw-bold w-100">Register</button>
                        <div class="w-100 m-auto py-3 text-uppercase fw-medium text-center">
                            or
                        </div>
                        <a href="{{route('login')}}" class="btn btn-outline-primary px-5 py-3 text-uppercase fw-bold w-100">Already have an account</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
