@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">show</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row w-50">
        <div class="col">
            <h1 class="text-primary">{{$role->name}}</h1>
            <ul class="list-group">
                <li class="list-group-item bg-black-5"><h3 class="text-white">Permissions</h3></li>
                @foreach($permissions  as $permission)

                <li class="list-group-item">{{$permission->name}}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row">

    </div>
    <!-- row closed -->

    <!-- main-content closed -->
@endsection
@section('js')
@endsection
