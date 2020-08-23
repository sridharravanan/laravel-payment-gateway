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
                    @include('tutor.form')
                </div>
            </div>
        </div>
    </form-tutor>
@endsection
