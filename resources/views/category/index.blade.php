<?php
/**
 * Created by IntelliJ IDEA.
 * User: sridhar
 * Date: 18/8/20
 * Time: 8:17 PM
 */
?>
@extends('layouts.app')

@section('content')
<manage-category inline-template>
    <div>
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Category</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li class="active">Category</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-6"><strong class="card-title">Data Table</strong></div>
                                <div class="col-lg-6">
                                    @include('__global.search_bar')
                                </div>
                            </div>


                        </div>
                        <div class="card-body">
                            <vue-table ref="vuetable"
                                       api-url="/category"
                                       :fields="fields"
                                       pagination-path=""
                                       :http-fetch="vueTableFetch"
                                       @vuetable:pagination-data="onPaginationData"
                                       :append-params="vueTableParams"
                                       :css="css.table"
                            >
                            </vue-table>
                            <div class="row">
                                <div class="col-sm-12 col-md-5" >
                                    <vuetable-pagination-info  ref="paginationInfo"></vuetable-pagination-info>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <vuetable-pagination
                                        ref="pagination"
                                        :css="css.pagination"

                                        @vuetable-pagination:change-page="onChangePage"
                                    ></vuetable-pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</manage-category>

@endsection
