@extends('layouts.master')
<title>{{__('Invoices')}}</title>
@section('css')
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Invoices')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Invoices List')}}</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
            <span class="alert-inner--text"><strong>{{__('Success')}}!</strong>   {{session()->get('Add')}}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @elseif(session()->has('Edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
            <span class="alert-inner--text"><strong>{{__('Success')}}!</strong>   {{session()->get('Edit')}}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @elseif(session()->has('forceDelete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
            <span class="alert-inner--text"><strong>{{__('Success')}}!</strong>   {{session()->get('forceDelete')}}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @elseif(session()->has('archive'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
            <span class="alert-inner--text"><strong>{{__('Success')}}!</strong>   {{session()->get('archive')}}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @elseif(session()->has('status_update'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
            <span class="alert-inner--text"><strong>{{__('Success')}}!</strong>   {{session()->get('status_update')}}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    <div class="row">


        <div class="col">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <a class="model-affect btn  btn-primary" href="{{route('invoices.create',app()->getLocale())}}">
                        + {{__('add invoice')}}
                    </a>
                    <a href="{{URL(app()->getLocale().'/export')}}" class="btn btn-dark">{{__('Export Excel')}}</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">{{__('num')}}</th>
                                <th class="border-bottom-0">{{__('date')}}</th>
                                <th class="border-bottom-0">{{__('due date')}}</th>
                                <th class="border-bottom-0">{{__('product')}}</th>
                                <th class="border-bottom-0">{{__('section')}}</th>
                                <th class="border-bottom-0">{{__('discount')}}</th>
                                <th class="border-bottom-0">{{__('rate vat')}}</th>
                                <th class="border-bottom-0">{{__('value vat')}}</th>
                                <th class="border-bottom-0">{{__('total')}}</th>
                                <th class="border-bottom-0">{{__('status')}}</th>
                                <th class="border-bottom-0">{{__('controls')}}</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{$invoice->id}}</td>
                                    <td>{{$invoice->invoice_number}}</td>
                                    <td>{{$invoice->invoice_date}}</td>
                                    <td>{{$invoice->due_date}}</td>
                                   <td>{{$invoice->product_id}}<td>
                                    <a href="{{URL(app()->getLocale().'/invoices/'.$invoice->id)}}">
                                        {{$invoice->section->section_name}}
                                    </a>
                                    </td>
                                    <td>{{$invoice->discount}}</td>
                                    <td>{{$invoice->rate_vat}}</td>
                                    <td>{{$invoice->value_vat}}</td>
                                    <td>{{$invoice->total}}</td>
                                    <td>
                                        @if($invoice->status->value == 1)
                                            <span class="text-danger">{{__('unpaid')}}</span>
                                        @elseif($invoice->status->value == 2)
                                            <span class="text-info">{{__('partial')}}</span>
                                        @else
                                            <span class="text-success">{{__('paid')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary"
                                                    data-toggle="dropdown" type="button">{{__('Menu')}}<i class="fas fa-caret-down ml-1"></i></button>
                                            <div class="dropdown-menu tx-13">
                                                <a class="dropdown-item" href="{{route('invoices.edit',[app()->getLocale(),$invoice->id])}}">{{__('Edit')}}</a>
                                                <a class="dropdown-item" href="{{route('status_show',[app()->getLocale(),$invoice->id])}}">{{__('change status')}}</a>
                                                <a class="dropdown-item" href="javascript:document.getElementById('delete_form').submit();">{{__('Delete')}}</a>
                                                <form method="POST" id="delete_form" action="{{route('invoices.destroy',[app()->getLocale(),$invoice->id])}}">
                                                    @method('DELETE')
                                                    @csrf
                                                </form>
                                                <a class="dropdown-item" href="javascript:document.getElementById('archive_form').submit();">{{__('Archive')}}</a>
                                                <form method="post" id="archive_form" action="{{route('archive',[app()->getLocale(),$invoice->id])}}"  >
                                                    @csrf
                                                </form>
                                                <a class="dropdown-item" href="{{URL(app()->getLocale()."/print/".$invoice->id)}}">{{__('Print')}}</a>

                                            </div>
                                        </div>


                                    </td>


                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->

        <!--div-->

    </div>

    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>
@endsection
