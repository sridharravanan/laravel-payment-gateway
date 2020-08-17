<?php
/**
 * Created by IntelliJ IDEA.
 * User: sridhar
 * Date: 17/8/20
 * Time: 9:19 PM
 */
?>
@extends('layouts.login')
@section('content')
    <form-tutor inline-template>
        <div class="container">
            <div class="login-content">
                @include('__global.loading')
                <div class="login-logo">
                    <img class="align-content" src="{{asset('image/logo.jpg')}}" alt="Logo">
                </div>
                <div class="login-form">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label>Name*</label>
                            <input type="text" placeholder="Name" class="form-control" v-bind:class="{ 'is-invalid' : formErrors.$errors.has('name') }" v-model="form.name">
                            <div class="invalid-feedback" v-show="formErrors.$errors.has('name')">
                                @{{ formErrors.$errors.first('name') }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email Address*</label>
                            <input type="email"  placeholder="Email"  class="form-control" v-bind:class="{ 'is-invalid' : formErrors.$errors.has('email') }" v-model="form.email">
                            <div class="invalid-feedback" v-show="formErrors.$errors.has('email')">
                                @{{ formErrors.$errors.first('email') }}
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-12">
                                <label>Phone Number*</label>
                                <div class="input-group">
                                    <div class="input-group-btn"><button class="btn btn-primary">+91</button></div>
                                    <input type="text"  placeholder="Phone Number"  class="form-control" v-bind:class="{ 'is-invalid' : formErrors.$errors.has('phone_number') }" v-model="form.phone_number">
                                    <div class="invalid-feedback" v-show="formErrors.$errors.has('phone_number')">
                                        @{{ formErrors.$errors.first('phone_number') }}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password*</label>
                            <input type="password" placeholder="Password"  class="form-control" v-bind:class="{ 'is-invalid' : formErrors.$errors.has('password') }" v-model="form.password">
                            <div class="invalid-feedback" v-show="formErrors.$errors.has('password')">
                                @{{ formErrors.$errors.first('password') }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password*</label>
                            <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control"  v-model="form.password_confirmation">
                        </div>

                        <button type="button" class="btn btn-primary btn-block m-b-30 m-t-30" @click="submit">Register</button>
                        <div class="register-link m-t-15 text-center">
                            <p>Already have account ? <a href="{{ route('login') }}"> Sign in</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </form-tutor>
@endsection
