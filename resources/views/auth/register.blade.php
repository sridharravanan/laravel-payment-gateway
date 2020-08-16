@extends('layouts.login')

@section('content')
<div class="container">
    <div class="login-content">
        <div class="login-logo">
            <img class="align-content" src="{{asset('image/logo.jpg')}}" alt="Logo">
        </div>
        <div class="login-form">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" placeholder="Name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Email address</label>
                    <input type="email"  placeholder="Email"  class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row form-group">
                    <div class="col col-md-12">
                        <label>Phone address</label>
                        <div class="input-group">
                            <div class="input-group-btn"><button class="btn btn-primary">+91</button></div>
                            <input type="text" id="input3-group2"  placeholder="Phone Number" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="phone_number">
                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary btn-block m-b-30 m-t-30">Register</button>
                <div class="register-link m-t-15 text-center">
                    <p>Already have account ? <a href="{{ route('login') }}"> Sign in</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
