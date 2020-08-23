<?php
/**
 * Created by IntelliJ IDEA.
 * User: sridhar
 * Date: 19/8/20
 * Time: 9:28 PM
 */
?>
@extends('layouts.app')

@section('content')
<manage-tutor inline-template>
    <div>
        <div class="content mt-3">
            <div class="row" v-if="!displayForm">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-7"><strong class="card-title">Tutor</strong></div>

                                <div class="col-lg-1">
                                    <button type="button" class="btn btn-warning" @click="showForm"><i class="fa fa-plus"></i>&nbsp; Add</button>
                                </div>
                                <div class="col-lg-4">
                                    @include('__global.search_bar')
                                </div>
                            </div>


                        </div>
                        <div class="card-body">
                            <vue-table ref="vuetable"
                                       api-url="/tutor/grid"
                                       :fields="fields"
                                       pagination-path=""
                                       :http-fetch="vueTableFetch"
                                       @vuetable:pagination-data="onPaginationData"
                                       :append-params="vueTableParams"
                                       :css="css.table"
                            >
                                <template slot="actions" scope="props">
                                    <div class="custom-actions">
                                        <button type="button" class="btn btn-primary" @click="onAction('edit-item', props.rowData, props.rowIndex)"><i class="fa fa-pencil"></i>&nbsp; Edit</button>
                                    </div>
                                </template>
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
            <div class="row" v-if="displayForm">
                <form-tutor inline-template>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-11"><strong class="card-title">@{{formTitle}} Post</strong></div>
                                    <div class="col-lg-1"><button type="button" class="btn btn-primary" @click="showGrid">Manage</button></div>
                                </div>
                            </div>
                            <div class="card-body">
                                @include('__global.loading')
                                @include('tutor.form')
                            </div>
                        </div>
                    </div>

                </form-tutor>
            </div>

        </div>
    </div>
</manage-tutor>

@endsection
