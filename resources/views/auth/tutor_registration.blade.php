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
                            <input type="text" placeholder="Name" class="form-control" v-bind:class="{ 'is-invalid' : errors.name }" v-model="form.name">
                            <div class="invalid-feedback" v-if="errors.name">
                                @{{ errors.name['0'] }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email Address*</label>
                            <input type="email"  placeholder="Email"  class="form-control" v-bind:class="{ 'is-invalid' : errors.email }" v-model="form.email">
                            <div class="invalid-feedback" v-if="errors.email">
                                @{{ errors.email['0'] }}
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-12">
                                <label>Phone Number*</label>
                                <div class="input-group">
                                    <div class="input-group-btn"><button class="btn btn-primary">+91</button></div>
                                    <input type="text"  placeholder="Phone Number"  class="form-control" v-bind:class="{ 'is-invalid' : errors.phone_number }" v-model="form.phone_number">
                                    <div class="invalid-feedback" v-if="errors.phone_number">
                                        @{{ errors.phone_number['0'] }}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password*</label>
                            <input type="password" placeholder="Password"  class="form-control" v-bind:class="{ 'is-invalid' : errors.password }" v-model="form.password">
                            <div class="invalid-feedback" v-if="errors.password">
                                @{{ errors.password['0'] }}
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
