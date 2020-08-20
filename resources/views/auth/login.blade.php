@extends('layouts.login')

@section('content')
<div class="container">
    <div class="login-content">
        <div class="login-logo">
            <img class="align-content" src="{{asset('image/logo.jpg')}}" alt="Logo">
        </div>
        <div class="login-form">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label>Email address</label>
                    <input type="email"  placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-block m-b-30 m-t-30">Sign in</button>
                <div class="register-link  mt-1">
                    <div class="row">
                        <div class="col-lg-6"><a  href="{{ route('register') }}"> Student Sign Up</a></p></div>
                        <div class="col-lg-6 "><a class=" pull-right" href="{{ route('tutor-registration') }}"> Tutor Sign Up</a></p></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
