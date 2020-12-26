@extends('layouts.master')

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row w-50">
        <div class="col w-50">
            <br>
            <hr>
        <form method="post" action="{{route('roles.store')}}">
            @csrf
            @if(isset($role))
                <input type="hidden" name="id" value="{{$role->id}}">
            @endif
            <label for="name">name</label>
            <div class="input-group mb-3">
                <input value="{{isset($role)  ? $role->name : '' }}" name="name" type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="card">
                <div class="card-header">
                    Permissions
                    <hr>
                </div>
                <div class="card-body">
                    @foreach($permissions as $permission)
                        <div class="form-check d-inline">
                            <input {{isset($role) ? $role->hasPermissionTo($permission) ?  'checked' : '' : ''}} type="checkbox" name="permissions[]" value="{{$permission->id}}">
{{--                            <input  type="checkbox" name="permissions[]" value="{{$permission->id}}"  selected>--}}
                            <label>{{$permission->name}}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <input type="submit"  value="{{isset($role) ? ' update' : 'Add'}}" class="btn btn-success float-left">

        </form>
    </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
@endsection
