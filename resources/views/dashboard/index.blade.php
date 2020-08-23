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
                                <div class="col-md-3">
                                    <div class="card">
                                        <img class="card-img-top" src="image/no-image-available.jpg" alt="Card image cap">
                                        <div class="card-body">
                                            <h4 class="card-title mb-3">Card Image Title</h4>
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card">
                                        <img class="card-img-top" src="image/no-image-available.jpg" alt="Card image cap">
                                        <div class="card-body">
                                            <h4 class="card-title mb-3">Card Image Title</h4>
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card">
                                        <img class="card-img-top" src="image/no-image-available.jpg" alt="Card image cap">
                                        <div class="card-body">
                                            <h4 class="card-title mb-3">Card Image Title</h4>
                                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card">
                                        <img class="card-img-top" src="image/no-image-available.jpg" alt="Card image cap">
                                        <div class="card-body">
                                            <h4 class="card-title mb-3">Card Image Title</h4>
                                            <hr>
                                            <!--<button type="button" class="btn btn-outline-danger btn-lg btn-block"><i class="fa fa-download"></i>&nbsp;Download</button>-->
                                            <button type="button" class="btn btn-outline-danger btn-lg btn-block"> <i class="fa fa-download"></i>&nbsp;BUY</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_simple_numbers">
                                        <paginate
                                            :page-count="20"
                                            :page-range="3"
                                            :margin-pages="2"
                                            :click-handler="functionName"
                                            :prev-text="'Prev'"
                                            :next-text="'Next'"
                                            :container-class="'pagination'"
                                            :page-class="'paginate_button page-item'">
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
