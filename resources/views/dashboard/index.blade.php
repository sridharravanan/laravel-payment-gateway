<?php
/**
 * Created by IntelliJ IDEA.
 * User: sridhar
 * Date: 21/8/20
 * Time: 10:29 PM
 */
?>
@extends('layouts.app')

@section('content')
<manage-dashboard inline-template>
    <div>
        <div class="content mt-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @include('__global.loading')
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="stat-widget-one">
                                                <div class="stat-icon dib"><i class="fa fa-group text-primary border-primary"></i></div>
                                                <div class="stat-content dib">
                                                    <div class="stat-text">Total Student</div>
                                                    <div class="stat-digit">@{{header_value.total_students}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="stat-widget-one">
                                                <div class="stat-icon dib"><i class="fa fa-group text-danger border-danger"></i></div>
                                                <div class="stat-content dib">
                                                    <div class="stat-text">Total Tutors</div>
                                                    <div class="stat-digit">@{{header_value.total_tutors}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="stat-widget-one">
                                                <div class="stat-icon dib"><i class="fa fa-book text-warning border-warning"></i></div>
                                                <div class="stat-content dib">
                                                    <div class="stat-text">Total Post</div>
                                                    <div class="stat-digit">@{{header_value.total_posts}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-lg-7"><strong class="card-title">Post</strong></div>
                                            <div class="col-lg-5">
                                                @include('__global.search_bar')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12" v-if="postLists.length == 0">
                                                <div class="alert alert-danger" role="alert">
                                                    There is no post..!
                                                </div>
                                            </div>
                                            <input  type="hidden"   id="user_data" value="{{$user_data}}" >
                                            <input  type="hidden"  id="razorpay_key" value="{{$razorpay_key}}">
                                            <div class="col-lg-3" v-for="( post,index ) in postLists">
                                                <div class="card">
                                                    <img class="card-img-top" :src="post.front_image.uploaded_path | bindImage" alt="post.name">
                                                    <div class="card-body">
                                                        <h4 class="card-title">@{{post.name}}</h4>
                                                        <hr class="m-1">
                                                        <p class="m-1">
                                                            <small>Author -<b>@{{post.tutor.name}}</b></small></br>
                                                            <small>Category -<b>@{{post.category_name}}</b></small>
                                                        </p>
                                                        <button type="button" v-if="checkPaymentStatus(index)" :data-author="post.name" :data-id="post.id" :data-amount="post.amount" class="btn btn-outline-danger btn-lg btn-block buy_now"> <i class="fa fa-download"></i>&nbsp;BUY Rs.@{{post.amount}}</button>
                                                        <a target="_blank" :href="post.post_pdf.uploaded_path | bindImage"  v-else class="btn btn-outline-danger btn-lg btn-block"> <i class="fa fa-download"></i>&nbsp;Download</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row"  v-if="postLists.length != 0">
                                            <div class="col-sm-12">
                                                <div class="dataTables_paginate paging_simple_numbers pull-right">
                                                    <paginate
                                                        v-model="currentPage"
                                                        :page-count="totalPage"
                                                        :page-range="3"
                                                        :margin-pages="2"
                                                        :click-handler="getAllPost"
                                                        :prev-text="previousButton"
                                                        :next-text="nextButton"
                                                        :container-class="'pagination'"
                                                        :page-class="'paginate_button page-item'"
                                                        :page-link-class="'page-link'"
                                                    >
                                                    </paginate>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</manage-dashboard>
@endsection
@push('scripts')
<script type="text/javascript">
    jQuery(document).on('click', '.buy_now', function(e){
       // var amountInPaise = 100;
        var totalAmount = parseFloat($(this).attr("data-amount")).toFixed(2);
        var amountInPaise = parseInt(totalAmount * 100);
        var post_id =  $(this).attr("data-id");
        var user    = JSON.parse($("#user_data").val());
        console.log(amountInPaise)
        var options = {
            "key": $("#razorpay_key").val(),
            "amount": amountInPaise, // 2000 paise = INR 20
            "name": $(this).attr("data-author"),
            "description": "Payment",
            "image": " ",
            "prefill": {
                "contact": '91'+user.phone_number,
                "email":   user.email,
            },
            "handler": function (response){
                let razorpay_payment_id = response.razorpay_payment_id;
                axios.post('/dashboard/pay-success', {
                        payment_id:  razorpay_payment_id,
                        amount : totalAmount,
                        post_id : post_id,
                    })
                    .then(function (response) {
                        window.location.href="/dashboard/post-download/"+razorpay_payment_id;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            },

        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
        e.preventDefault();
    });
</script>
@endpush
