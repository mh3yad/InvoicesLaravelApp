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
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قايمة الفواتير</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
        <div class="col">
            <div class="card mg-b-20 p-4">
                <form action="" id="myForm" onsubmit="return false">
                    <div class="card-header pb-0">
                            <label  class="rdiobox"><input id="type" name="rdio" type="radio" checked> <span>Search by type</span></label>
                            <label  class="rdiobox"><input id="number" name="rdio" type="radio"> <span>Search by number</span></label>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="formType">
                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">type</label>
                                <select id="invoiceType" name="invoiceType" class="form-control ">
                                    <option value="" disabled selected>choose type</option>
                                    @foreach($status as $s)
                                        <option value="{{$s->value}}">{{$s->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label>from date</label>
                                <input class="form-control fc-datepicker" name="from_date" placeholder="YYYY-MM-DD"
                                       type="text" >
                            </div>
                            <div class="col">
                                <label>to date </label>
                                <input class="form-control fc-datepicker" name="to_date" placeholder="YYYY-MM-DD"
                                       type="text" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="formNumber">
                            <div class="form-group">
                                <lable>search with number</lable>
                                <input id="invoiceNumber" name="invoiceNumber" type="text" class="form-control" placeholder="Enter invoice number">
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <input class="btn btn-primary w-25" type="submit" value="Search" id="search" name="search">
                </form>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">رقم الفاتورة</th>
                                <th class="border-bottom-0">تاريخ الفاتورة</th>
                                <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                <th class="border-bottom-0">المنتج</th>
                                <th class="border-bottom-0">القسم</th>
                                <th class="border-bottom-0">الخصم</th>
                                <th class="border-bottom-0">نسبة الضريبة</th>
                                <th class="border-bottom-0">قيمة الضريبة</th>
                                <th class="border-bottom-0">الاجمالي</th>
                                <th class="border-bottom-0">الحالة</th>
                                <th class="border-bottom-0">ملحظات</th>
                            </tr>
                            </thead>
                            <tbody id="tableBody">
                            {{--                            @foreach($invoices as $invoice)--}}
                            {{--                                <tr>--}}
                            {{--                                    <td>{{$invoice->id}}</td>--}}
                            {{--                                    <td>{{$invoice->invoice_number}}</td>--}}
                            {{--                                    <td>{{$invoice->invoice_date}}</td>--}}
                            {{--                                    <td>{{$invoice->due_date}}</td>--}}
                            {{--                                    <td>{{$invoice->product_id}}<td>--}}
                            {{--                                        <a href="{{route('invoices.show',$invoice->id)}}">--}}
                            {{--                                            {{$invoice->section->section_name}}--}}
                            {{--                                        </a>--}}
                            {{--                                    </td>--}}
                            {{--                                    <td>{{$invoice->discount}}</td>--}}
                            {{--                                    <td>{{$invoice->rate_vat}}</td>--}}
                            {{--                                    <td>{{$invoice->value_vat}}</td>--}}
                            {{--                                    <td>{{$invoice->total}}</td>--}}
                            {{--                                    <td>--}}
                            {{--                                        @if($invoice->status->value == 1)--}}
                            {{--                                            <span class="text-info">{{$invoice->status->name}}</span>--}}
                            {{--                                        @elseif($invoice->status->value == 2)--}}
                            {{--                                            <span class="text-danger">{{$invoice->status->name}}</span>--}}
                            {{--                                        @else--}}
                            {{--                                            <span class="text-success">{{$invoice->status->name}}</span>--}}
                            {{--                                        @endif--}}
                            {{--                                    </td>--}}
                            {{--                                    <td>--}}
                            {{--                                        <div class="dropdown">--}}
                            {{--                                            <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary"--}}
                            {{--                                                    data-toggle="dropdown" type="button">Menu<i class="fas fa-caret-down ml-1"></i></button>--}}
                            {{--                                            <div class="dropdown-menu tx-13">--}}
                            {{--                                                <a class="dropdown-item" href="{{route('invoices.edit',$invoice->id)}}">Edit</a>--}}
                            {{--                                                <a class="dropdown-item" href="{{route('status_show',$invoice->id)}}">change status</a>--}}
                            {{--                                                <a class="dropdown-item" href="javascript:document.getElementById('delete_form').submit();">Delete</a>--}}
                            {{--                                                <form method="POST" id="delete_form" action="{{route('invoices.destroy',$invoice->id)}}">--}}
                            {{--                                                    @method('DELETE')--}}
                            {{--                                                    @csrf--}}
                            {{--                                                </form>--}}
                            {{--                                                <a class="dropdown-item" href="javascript:document.getElementById('archive_form').submit();">Archive</a>--}}
                            {{--                                                <form method="post" id="archive_form" action="{{route('archive',$invoice->id)}}"  >--}}
                            {{--                                                    @csrf--}}
                            {{--                                                </form>--}}
                            {{--                                                <a class="dropdown-item" href="/print/{{$invoice->id}}">Print</a>--}}

                            {{--                                            </div>--}}
                            {{--                                        </div>--}}


                            {{--                                    </td>--}}


                            {{--                                </tr>--}}
                            {{--                            @endforeach--}}
                            </tbody>
                        </table>

                    </div>
                </div>
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

            $('#search').click(function () {
                $status = $('#invoiceType').val()
                $('#tableBody').html("")
                console.log($('form#myForm').serialize())

               {
                    $.ajax({
                        url: "/reportInvoiceRequest",
                        type: "GET",
                        data: $('form#myForm').serialize(),
                        dataType: "json",

                        success: function (data) {
                            $.each(data,function (key,value){
                                $('#tableBody').append('<tr class="text-center">' +
                                    '<td>'+value.id+'</td>' +
                                    '<td>'+value.invoice_number+'</td>' +
                                    '<td>'+value.invoice_date+'</td>' +
                                    '<td>'+value.due_date+'</td>' +
                                    '<td>'+value.product_id+'</td>' +
                                    '<td>'+value.section_id+'</td>' +
                                    '<td>'+value.discount+'</td>' +
                                    '<td>'+value.rate_vat+'</td>' +
                                    '<td>'+value.value_vat+'</td>' +
                                    '<td>'+value.total+'</td>' +
                                    '<td>'+(value.status_id === 1 ? '<span class="text-danger">unpaid </span> ' : value.status_id === 2 ?  '<span class="text-info">partial</span>' : '<span class="text-success">paid </span>')+'</td>' +


                                    '</tr>')
                            })
                        },
                    });

                }
                $(this).closest('form').find("input[type=text], textarea").val("");

            });

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
