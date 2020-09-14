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
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-7"><strong class="card-title">All Post</strong></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="" v-if="postLists.length == 0">
                                    <div class="alert alert-danger" role="alert">
                                        There is no post..!
                                    </div>
                                </div>
                                <div class="col-md-3" v-for="( post,index ) in postLists">
                                    <div class="card">
                                        <img class="card-img-top" :src="post.front_image.uploaded_path | bindImage" alt="post.name">
                                        <div class="card-body">
                                            <h4 class="card-title">@{{post.name}}</h4>
                                            <hr class="m-1">
                                            <p class="m-1">
                                                <small>Author -<b>@{{post.name}}</b></small></br>
                                                <small>Category -<b>@{{post.category_name}}</b></small>
                                            </p>
                                            <button type="button" :data-id="post.id" :data-amount="post.amount" class="btn btn-outline-danger btn-lg btn-block buy_now"> <i class="fa fa-download"></i>&nbsp;BUY Rs.@{{post.amount}}</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
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
</manage-dashboard>
@endsection
