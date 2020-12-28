@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Reports customers')}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"></span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    <form action="{{route('customers',app()->getLocale())}}">
        <div class="row">
            <div class="col">
                <label for="inputName" class="control-label">{{__('section')}}</label>
                <select name="section_id" class="form-control ">
                    <!--placeholder-->
                    <option value="" selected disabled>{{__('specify section')}}م</option>
                    @foreach ($sections as $section)
                        <option value="{{$section->id}}" {{ isset($invoice) ? $invoice->section_id == $section->id ? 'selected' : '' : '' }}> {{ $section->section_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col">
                <label for="product" class="control-label">{{__('product')}}</label>
                <select id="product_id" name="product_id" class="form-control">
                    @if(isset($invoice))
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col">
                <label>{{__('from date')}}</label>
                <input class="form-control fc-datepicker" name="from_date" placeholder="YYYY-MM-DD"
                       type="text" >
            </div>
            <div class="col">
                <label>{{__('to date')}}</label>
                <input class="form-control fc-datepicker" name="to_date" placeholder="YYYY-MM-DD"
                       type="text" >
            </div>
        </div>
        <div class="row">
            <div class="col">
                <input class="btn btn-dark w-25 my-5" type="submit" value="submit">
            </div>
        </div>
    </form>
    @if(isset($invoices))
    <div class="row">
        <div class="col">
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
    @endif
@endsection
@section('js')
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

    <script>
        $('select[name="section_id"]').on('change', function () {


            var SectionId = $(this).val();
            let lang =  $(location).attr("href").split('\/')[3];
            if (SectionId) {
                $.ajax({
                    url: "/"+lang + '/section/' + SectionId,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('select[name="product_id"]').empty()
                        $.each(data,function (key,value){

                            $('select[name="product_id"]').append('<option value="'+ value.id +'">'+value.product_name+'</option>')
                        })
                    },
                });

            } else {
                console.log('AJAX load did not work');
            }

        });
    </script>
@endsection
