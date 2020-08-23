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
<manage-post inline-template>
    <div>
        <div class="content mt-3">
            @if(is_null(Auth::user()->razorpay_id))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger" role="alert">
                            Contact Admin to assign razorpay,then only you can make post
                        </div>
                    </div>
                </div>
            @else
            <div class="row" v-if="!displayForm">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-7"><strong class="card-title">Post</strong></div>

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
                                       api-url="/post/grid"
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
                <form-post inline-template>
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
                                <form method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Name*</label>
                                                <input type="text" placeholder="Name" class="form-control" v-bind:class="{ 'is-invalid' : formErrors.$errors.has('name') }" v-model="form.name">
                                                <div class="invalid-feedback" v-show="formErrors.$errors.has('name')">
                                                    @{{ formErrors.$errors.first('name') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Category *</label>
                                                <v-select
                                                    :options="category_options"
                                                    :searchable="true"
                                                    :multiple="false"
                                                    label="name"
                                                    track-by="id"
                                                    :show-labels="false"
                                                    v-model="category"
                                                    @input = "bindSubCategory"
                                                ></v-select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Sub Category *</label>
                                                <v-select
                                                    :options="sub_category_options"
                                                    :searchable="true"
                                                    :multiple="false"
                                                    label="name"
                                                    track-by="id"
                                                    :show-labels="false"
                                                    v-model="sub_category"
                                                    v-bind:class="{ 'is-invalid' : formErrors.$errors.has('sub_category_id') }"
                                                ></v-select>
                                                <div class="invalid-feedback" v-show="formErrors.$errors.has('sub_category_id')">
                                                    @{{ formErrors.$errors.first('sub_category_id') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <!--<input type="text" id="result" v-model="amount">-->
                                                @{{amount}}
                                                <label>Amount*</label>
                                                <input type="text" placeholder="Name" class="form-control" v-bind:class="{ 'is-invalid' : formErrors.$errors.has('amount') }" v-model="form.amount">
                                                <div class="invalid-feedback" v-show="formErrors.$errors.has('amount')">
                                                    @{{ formErrors.$errors.first('amount') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">

                                            <div class="card">
                                                <div class="card-header">
                                                    <strong class="card-title">Other Tutor's <span class=" float-right mt-1"><button type="button" class="btn btn-warning" @click="addTutor"><i class="fa fa-plus"></i>&nbsp; Add</button></span></strong>
                                                </div>
                                                <div class="card-body">
                                                    <table class="table table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">S.No</th>
                                                            <th scope="col">Tutor Name</th>
                                                            <th scope="col">Amount</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr v-if="form.post_tutors.length == 0">
                                                            <td colspan="4">No data</td>
                                                        </tr>
                                                        <tr v-for="( post_tutor,index ) in form.post_tutors">
                                                            <td>
                                                                @{{ index+1 }}
                                                            </td>
                                                            <td>
                                                                <v-select
                                                                    :options="tutor_options"
                                                                    :searchable="true"
                                                                    :multiple="false"
                                                                    label="name"
                                                                    track-by="id"
                                                                    :show-labels="false"
                                                                    v-model="post_tutor.tutor"
                                                                    @input = "checkDuplicateTutor(index)"
                                                                    v-bind:class="{ 'is-invalid' : formErrors.$errors.has('post_tutors.'+index+'.tutor_id') }"
                                                                ></v-select>
                                                                <div class="invalid-feedback" v-show="formErrors.$errors.has('post_tutors.'+index+'.tutor_id')">
                                                                    @{{ formErrors.$errors.first('post_tutors.'+index+'.tutor_id') }}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="text" placeholder="Amount"
                                                                       v-bind:class="{ 'is-invalid' : formErrors.$errors.has('post_tutors.'+index+'.amount') }" :disabled="true"
                                                                       class="form-control" v-model="post_tutor.amount">
                                                                <div class="invalid-feedback" v-show="formErrors.$errors.has('post_tutors.'+index+'.amount')">
                                                                    @{{ formErrors.$errors.first('post_tutors.'+index+'.amount') }}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger" @click="onDeleteTutorBlock(index)"><i class="fa fa-times"></i>&nbsp; Delete</button>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label>Front Cover(Only Image File)</label>
                                            <!--<file-pond
                                                v-if="form.front_image_id == null"
                                                name="attachment"
                                                key="attachment"
                                                ref="pond"
                                                class-name="my-pond"
                                                label-idle="Drop files here..."
                                                allowMultiple="false"
                                                image-preview-height = "200"
                                                allow-image-preview ="true"
                                                accepted-file-types="image/*"
                                                :server="filePondOptions"
                                                v-on:processfile="onFileUploadComplete"
                                                :allow-revert = "true"
                                            ></file-pond>-->
                                            <div v-if="form.front_image_id == null">
                                                <button type="button"  @click="toggleCropperShow" class="btn btn-outline-secondary btn-lg btn-block"><i class="fa fa-upload"></i>&nbsp; Click Here To Upload Image</button>
                                                <my-upload field="attachment"
                                                           @crop-upload-success="cropUploadSuccess"
                                                           @crop-upload-fail="cropUploadFail"
                                                           v-model="fileCropperShow"
                                                           :width="150"
                                                           :height="150"
                                                           url="/upload"
                                                           :headers="filePondOptions.process.headers"
                                                           lang-type="en"
                                                           img-format="png"></my-upload>
                                            </div>
                                            <div class="card" v-else>
                                                <div class="card-header">
                                                    <strong class="card-title pl-2">@{{form.front_image.file_name}}
                                                        <button type="button" class="btn btn-outline-danger btn-sm float-right" @click="onDeleteFrontImage(false)"><i class="fa fa-times"></i></button>
                                                    </strong>
                                                </div>
                                                <div class="card-body">
                                                    <img class="rounded mx-auto d-block" :src="form.front_image.uploaded_path | bindImage" alt="Front Image">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 ">
                                            <label>Pdf(Only Pdf)</label>
                                            <file-pond
                                                v-if="form.post_pdf_id == null"
                                                name="attachment"
                                                key="attachment"
                                                ref="pond"
                                                class-name="my-pond "
                                                label-idle="Drop files here..."
                                                allowMultiple="false"
                                                allow-image-preview ="true"
                                                accepted-file-types="application/pdf"
                                                :server="filePondOptions"
                                                v-on:processfile="onPdfUploadComplete"
                                                :allow-revert = "true"
                                            ></file-pond>
                                            <div class="card " v-else>
                                                <div class="card-header">
                                                    <strong class="card-title pl-2">@{{form.post_pdf.file_name}}
                                                        <button type="button" class="btn btn-outline-danger btn-sm float-right" @click="onDeleteFrontImage(true)"><i class="fa fa-times"></i></button>
                                                    </strong>
                                                </div>
                                                <div class="card-body">
                                                    <embed type="application/pdf" :src="form.post_pdf.uploaded_path | bindImage"  height="200">
                                                </div>
                                            </div>
                                            <div class="custom-invalid-feedback" v-show="formErrors.$errors.has('post_pdf_id')">
                                                @{{ formErrors.$errors.first('post_pdf_id') }}
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label>Description</label>
                                            <vue-editor v-model="form.description"></vue-editor>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-12 ">
                                            <button type="button" class="btn btn-primary" @click="submit">Save</button>
                                            <button type="button" class="btn btn-secondary" @click="showGrid">Cancel</button>
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </form-post>
            </div>
            @endif
        </div>
    </div>
</manage-post>

@endsection
