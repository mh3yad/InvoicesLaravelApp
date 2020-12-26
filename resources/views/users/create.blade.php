@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Users</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Add</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row bg-white-7 p-3" >

        <div class="col">
            <form class="w-50" method="post" action="{{ route('users.store') }}">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="id" value="{{isset($user) ? $user->id : ''}}">
                    <label for="exampleInputEmail1">Name</label>
                    <input  id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{isset($user) ? $user->name : ''}}" required autocomplete="name" autofocus>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{isset($user) ? $user->email : ''}}" required autocomplete="email">
                </div>
                @if(!isset($user))
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  {{isset($user) ? '' : 'required'}} autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password Confirm</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" {{isset($user) ? '' : 'required'}} autocomplete="new-password">
                </div>
                @endif
                <div class="form-group">
                    <label for="status">User Status</label>
                    <select name="status" class="form-control" id="exampleFormControlSelect1">
                        <option value="0" {{isset($user) ? $user->status == 0 ? 'selected': '' : ' '}}>Off</option>
                        <option value="1" {{isset($user) ? $user->status ==1 ? 'selected': '' : ' '}}>On</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">User type</label>
                    <p class="text-danger d-block">*click ctrl to select sultiple</p>
                    <select name="roles[]" class="form-control" id="exampleFormControlSelect1" multiple>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}" {{isset($user) ? $user->hasRole($role->name) == true ? 'selected': '' : ' '}}>{{$role->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="text-center m-5">
                    <button type="submit" class="btn btn-primary justify-content-center">{{isset($user) ? 'Update' : 'Add'}}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
@endsection
