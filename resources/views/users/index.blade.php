@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('users')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    @if (session()->has('create'))
        <div class="alert alert-success">
            {{session()->get('create')}}
        </div>
    @elseif (session()->has('delete'))
        <div class="alert alert-danger">
            {{session()->get('delete')}}
        </div>
    @endif
   <div class="row">
       <div class="col">
           <div class="card mg-b-20">
               <div class="card-header pb-0">
                   <a class="model-affect " href="{{route('users.create',app()->getLocale())}}">
                               <button class="btn btn-primary-gradient btn-block w-25">{{__('add')}}</button>
                   </a>

               </div>
               <div class="card-body">
                   <div class="table-responsive">
                       <table id="example1" class="table key-buttons text-md-nowrap">
                           <thead>
                           <tr>
                               <th class="border-bottom-0">#</th>
                               <th class="border-bottom-0">{{__('user name')}}</th>
                               <th class="border-bottom-0">{{__('email')}}</th>
                               <th class="border-bottom-0">{{__('status')}} </th>
                               <th class="border-bottom-0"> {{__('type')}}</th>
                               <th class="border-bottom-0">{{__('controls')}}</th>

                           </tr>
                           </thead>
                           <tbody>
                           @foreach($users as $user)
                               <tr>



                                   <td>{{$user->id}}</td>
                                   <td>{{$user->name}}</td>
                                   <td>{{$user->email}}</td>
{{--                                   <td>{{$user->status}}</td>--}}
                                   <td>
                                       @if($user->status == 1)
                                           {{'On'}}
                                       @elseif($user->status ==2)
                                           {{'Of'}}
                                       @else
                                           {{ 'no data'}}
                                       @endif
                                   </td>
                                   <td>
                                       @foreach($user->roles as $role)
                                              {{count($user->roles) ? $role->name : 'no roles'}}
                                       @endforeach
                                   </td>


                                   <td>
                                       <!-- Call to action buttons -->
                                       <ul class="list-inline m-0">

                                            <li class="list-inline-item">
                                                <a href="{{route('users.edit',[app()->getLocale(),$user->id])}}"><button class="btn btn-warning-gradient btn-block" type="button"   title="Edit"><i class="typcn typcn-edit"></i></button>
                                                </a>
                                            </li>
                                           <li class="list-inline-item">
                                               <a href="javascript:document.getElementById('delete').submit()"><button class="btn btn-danger-gradient btn-block" type="button"   title="Delete"><i class="fa fa-trash"></i></button>
                                               </a>
                                           </li>
                                           <form method="post"  id="delete" action="{{route('users.destroy',[app()->getLocale(),$user->id])}}">
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
