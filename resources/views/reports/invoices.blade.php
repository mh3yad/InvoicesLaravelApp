@extends('layouts.master')
<title>الفواتير</title>
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
                <h4 class="content-title mb-0 my-auto">{{__('Reports invoices')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
        <div class="col">
            <div class="card mg-b-20 p-4">

                <form action="{{route('reportInvoiceRequests',app()->getLocale())}}" id="myForm" method="post">
                    @csrf
                    <div class="card-header pb-0">
                            <label  class="rdiobox"><input id="type" name="rdio" type="radio" checked> <span>{{__('Search by type')}}</span></label>
                            <label  class="rdiobox"><input id="number" name="rdio" type="radio"> <span>{{__('Search by number')}}</span></label>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="formType">
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">{{__('type')}}</label>
                                <select id="invoiceType" name="invoiceType" class="form-control ">
                                    <option value="" disabled selected>{{__('choose type')}}</option>
                                    @foreach($status as $s)
                                        <option value="{{$s->value}}">{{$s->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label>{{__('from date')}}</label>
                                <input class="form-control fc-datepicker" name="from_date" placeholder="YYYY-MM-DD"
                                       type="text" >
                            </div>
                            <div class="col">
                                <label>{{__('to date')}} </label>
                                <input class="form-control fc-datepicker" name="to_date" placeholder="YYYY-MM-DD"
                                       type="text" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="formNumber">
                            <div class="form-group">
                                <lable>{{__('Search by number')}}</lable>
                                <input id="invoiceNumber" name="invoiceNumber" type="text" class="form-control" >
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <input class="btn btn-primary w-25" type="submit" value="Search" id="search" >
                </form>
                @if(isset($invoices))
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
                @endif
            </div>
        </div>
        </div>
@endsection
@section('js')

    <script>
        $(document).ready(function () {
            $('.formNumber').hide()
            $('#type').change(function(){
                $(".formType").show()
                $('.formNumber').hide()
            })
            $('#number').change(function(){
                $(".formType").hide()
                $('.formNumber').show()
            })
            $('form#myForm').serialize()



        });

    </script>
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/date.js') }}"></script>
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
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>

@endsection
