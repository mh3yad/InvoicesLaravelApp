@extends('layouts.master')
@section('css')
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet"/>
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
    <!---Internal  Multislider css-->
    <link href="{{URL::asset('assets/plugins/multislider/multislider.css')}}" rel="stylesheet">
    <!--- Select2 css -->
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css"/>
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet"/>
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
<style>
    .example{
        color: white;
        background: white;
    }
</style>
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفاتورة </h4>
                {{--                    class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{$invoice->invoice_number}}</span>--}}
            </div>
        </div>
    </div>

    <div class="col">
        <div class="example">
            <div class="panel panel-primary tabs-style-2">
                <div class="tab-menu-heading">
                    <div class="tabs-menu1">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs main-nav-line">
                            <li class="nav-item"><a href="#tab4" class="nav-link  active" data-toggle="tab">{{__('invoice details')}}</a></li>
                            <li class="nav-item"><a href="#tab5" class="nav-link " data-toggle="tab">{{__('invoices statuses')}}</a>
                            </li>
                            <li class="nav-item"><a href="#tab6" class="nav-link " data-toggle="tab">{{__('attachments')}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab4">
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
                                    <tr>
                                        <td>{{$invoice->id}}</td>
                                        <td>{{$invoice->invoice_number}}</td>
                                        <td>{{$invoice->invoice_date}}</td>
                                        <td>{{$invoice->due_date}}</td>
                                        <td>{{$invoice->product_id}}
                                        <td>{{$invoice->section->section_name}}</td>
                                        <td>{{$invoice->discount}}</td>
                                        <td>{{$invoice->rate_vat}}</td>
                                        <td>{{$invoice->value_vat}}</td>
                                        <td>{{$invoice->total}}</td>
                                        <td>
                                            @if($invoice->status->value == 1)
                                                <span class="text-danger">{{$invoice->status->name}}</span>
                                            @elseif($invoice->status->value == 2)
                                                <span class="text-info">{{$invoice->status->name}}</span>
                                            @else
                                                <span class="text-success">{{$invoice->status->name}}</span>
                                            @endif
                                        </td>
                                        <td>{{$invoice->note}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane " id="tab5">
                            <div class="table-responsive">
                                <table id="example1" class="table key-buttons text-md-nowrap">
                                    <thead>
                                    <tr>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">{{__('num')}}</th>
                                        <th class="border-bottom-0">{{__('date')}}</th>
                                        <th class="border-bottom-0">{{__('status')}}</th>
                                        <th class="border-bottom-0">{{__('controls')}}</th>
                                        <th class="border-bottom-0">{{__('user')}}</th>
                                        <th class="border-bottom-0">{{__('notes')}}</th>
                                    </tr>
                                    </thead>
                                    <?php $i =1?>
                                    @foreach($details as $detail)
                                    <tbody>

                                        <tr>

                                            <td>{{$i++}}</td>
                                            <td>{{$detail->invoice_number}}</td>
                                            <td>{{$detail->created_at}}</td>
                                            <td>
                                                @if($invoice->status->value == 1)
                                                    <span class="text-danger">{{__('unpaid')}}</span>
                                                @elseif($invoice->status->value == 2)
                                                    <span class="text-info">{{__('partial')}}</span>
                                                @else
                                                    <span class="text-success">{{__('paid')}}</span>
                                                @endif
                                            </td>
                                            <td>{{$detail->user}}</td>
                                            <td>{{$detail->note}}</td>
                                        </tr>

                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane " id="tab6">
                            <br>
                            @if (session()->has('add-attachment'))
                                <div class="alert alert-success">
                                    {{session()->get('add-attachment')}}
                                </div>
                            @elseif(session()->has('delete-attach'))
                                <div class="alert alert-danger">
                                    {{session()->get('delete-attach')}}
                                </div>
                            @endif

                            <br>
                            <div class="row">
                                <div class="col">
                                    <p class="text-danger">* {{__('attach extension')}} pdf, jpeg ,.jpg , png </p>
                                    <h5 class="card-title">{{__('add attachment')}}</h5>
                                    <form action="{{route('addAttachment',app()->getLocale())}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-sm-12 col-md-12 w-25">
                                            <input name="file_name" type="file" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                   data-height="70"/>
                                            <input type="hidden" name="invoice_number" value="{{$invoice->invoice_number}}">
                                            <input type="hidden" name="invoice_id" value="{{$invoice->id}}">

                                        </div>
                                        <br>
                                        <div class="d-flex ">
                                            <button type="submit" class="btn btn-primary">{{__('add')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>
{{--                            <hr>--}}
                            <br>


                            <br>
                            <div class="table-responsive">

                                <table id="example1" class="table  key-buttons text-md-nowrap">
                                    <thead >
                                    <tr>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">{{__('attachment name')}}</th>
                                        <th class="border-bottom-0">{{__('controls')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($attachments as $attachment)
                                        <tr>

                                            <td>{{$attachment->id}}</td>
                                            <td>{{$attachment->file_name}}</td>
                                           <td>
                                        <div class="d-flex">

                                                      <a class="btn btn-outline-success" href="javascript:document.getElementById('download').submit()">
                                                          <i class="far fa-arrow-alt-circle-down"></i>  Download
                                                          <form method="post" action="{{route('download',[$invoice->invoice_number,$attachment->file_name,app()->getLocale()])}}" id="download">
                                                              @csrf
                                                          </form>
                                                      </a>

                                                      <a  class="btn btn-outline-info mx-4" href="{{asset(app()->getLocale().'/Attachments'.'/'.$invoice->invoice_number."/" . $attachment->file_name)}}" target="_blank" >
                                                          <i class="far fa-eye"></i>     show
                                                      </a>

                                                      <div class="modal" id="modaldemo1">
                                                          <div class="modal-dialog" role="document">
                                                              <div class="modal-content modal-content-demo">
                                                                  <div class="modal-header">
                                                                      <h6 style="display: block" class="modal-title">حذف</h6>
                                                              </div>
                                                                  <div class="modal-body">
                                                                      <p class="text-danger">are u sure u wanna delete?</p>
                                                              </div>

                                                              <div class="modal-footer">
                                                                  <a href="javascript:document.getElementById('delete').submit()" class="btn btn-outline-danger">
                                                                      <i class='far fa-trash-alt'></i>Delete
                                                                  </a>
                                                                  <form id="delete" class="text-left pos" action="{{route('delete',[$attachment->id,$invoice->invoice_number,app()->getLocale()])}}">
                                                                  </form>
                                                                  <button class="btn btn-dark" data-dismiss="modal" type="button">Close</button>
                                                              </div>
                                                              </div>

                                                              </div>
                                                          </div>
                                                   <a class="btn btn-outline-danger" data-target="#modaldemo1" data-toggle="modal" href="">حذف
                                                   </a>

                                               </div>

                                             </div>
                                         </div>



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
            </div>
        </div>
    </div>
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    {{--    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>--}}
    <!--Internal  jquery.maskedinput js -->
    {{--    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">--}}
    {{--    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>--}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/date.js') }}"></script>


@endsection




    <!-- breadcrumb -->
@endsection

@section('js')
@endsection
