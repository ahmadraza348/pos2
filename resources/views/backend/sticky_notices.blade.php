@extends('backend.layouts.layout')
@section('title', 'Sticky Notices - Raza Mall')
@section('content')
<div class="main-wrapper">


    <div class="page-wrapper cardhead">
        <div class="content ">

            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Sticky Note</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active">Sticky Note</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Sticky Note <a class="btn btn-primary float-sm-end m-l-10"
                                    id="add_new" href="javascript:;">Add New Note</a></h5>
                        </div>
                        <div class="card-body">
                            <div class="sticky-note" id="board"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection