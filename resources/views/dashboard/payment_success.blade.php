@extends('layouts.app')

@section('content')
    <div class="content mt-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Payment done successfully.!</h4>
                            <hr>
                            <table class="table table-striped ">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Item</th>
                                    <th scope="col">Value</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Payment Id</td>
                                    <td>{{$payment['payment_id']}}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Post Name</td>
                                    <td>{{$payment['post']['name']}}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Amount</td>
                                    <td>Rs.{{$payment['amount']}}</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Author Name</td>
                                    <td>{{$payment['post']['tutor']['name']}}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-center"><a target="_blank" class="btn btn-link" href="{{$payment['post']['postPdf']['uploaded_path']}}">Click Here To Download</a> </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
