@extends('layouts.master')
@section('css')
    .table {
    border-collapse: separate;
    border-spacing:0 20px;
    }
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">صلاحيات المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
    @if (session()->has('delete'))
        <div class="alert alert-danger">
            {{session()->get('delete')}}
        </div>
    @elseif (session()->has('create'))
        <div class="alert alert-success">
            {{session()->get('create')}}
        </div>
    @elseif (session()->has('update'))
        <div class="alert alert-info">
            {{session()->get('update')}}
        </div>

    @endif
    <!-- row -->
    <div class="row">
        <div class="col">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <a class="model-affect " href="{{route('roles.create')}}">
                        <button class="btn btn-primary-gradient btn-block w-25">Add</button>
                    </a>

                </div>
                <div class="card-body">
                    <div class="table-responsive text-center">
                        <table id="example1" class="table key-buttons text-md-nowrap">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">الأسم </th>
                                <th class="border-bottom-0 m-5">العمليات</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{$role->id}}</td>
                                    <td>{{$role->name}}</td>

                                    <td>
                                        <!-- Call to action buttons -->
                                        <ul class="list-inline m-0">
                                            <li class="list-inline-item">
                                                <a href="{{route('roles.show',$role->id)}}"> <button class="btn btn-success-gradient btn-block" type="button"   title="Edit">Show</button></a>
                                            </li>
                                            <li class="list-inline-item m-0">
                                                <a href="{{route('roles.edit',$role->id)}}"> <button class="btn btn-warning-gradient btn-block" type="button"   title="Edit">Edit</button></a>
                                            </li>

                                            <li class="list-inline-item">
                                                <a  href="javascript:document.getElementById('deleteRole').submit()" ><button class="btn btn-danger-gradient btn-block m-0"    type="button"   title="Delete">Delete</button></a>
                                            </li>
                                            <form method="post" action="{{route('roles.destroy',$role->id)}}" id="deleteRole">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        </ul>
                                    </td>


                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

@endsection
@section('js')
@endsection
