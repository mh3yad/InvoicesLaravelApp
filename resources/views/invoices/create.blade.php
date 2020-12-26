@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
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
@section('title')
    {{isset($invoice) ? 'تعديل الفاتورة' : 'اضافة فاتورة'}}
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                   {{isset($invoice) ? 'تعديل الفاتورة' : 'اضافة فاتورة'}}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">

        <div class="col -12">
            <div class="card">
                <div class="card-body">

                    <form action="{{route('invoices.store')}}" method="post" enctype="multipart/form-data"
                          autocomplete="off">
                        {{ csrf_field() }}

                        {{-- 1 --}}

                        <div class="row">

                            <div class="col">
                                <label for="inputName" class="control-label">رقم الفاتورة</label>
                                <input type="text" class="form-control" id="inputName" name="invoice_number"
                                       title="يرجي ادخال رقم الفاتورة" required
                                value=" {{isset($invoice) ? $invoice->invoice_number : ''}}"
                                >
                            </div>

                            <div class="col">
                                <label>تاريخ الفاتورة</label>
                                <input class="form-control fc-datepicker fc-today" name="invoice_date" placeholder="YYYY-MM-DD"
                                       type="text" required
                                       value=" {{isset($invoice) ? $invoice->invoice_date : ''}}"
                                >
                            </div>

                            <div class="col">
                                <label>تاريخ الاستحقاق</label>
                                <input class="form-control fc-datepicker" name="due_date" placeholder="YYYY-MM-DD"
                                       type="text" required
                                       value=" {{isset($invoice) ? $invoice->due_date : ''}}"
                                >
                            </div>

                        </div>


                        {{-- 2 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">القسم</label>
                                <select name="section_id" class="form-control SlectBox">
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد القسم</option>
                                    @foreach ($sections as $section)
                                        <option value="{{$section->id}}" {{ isset($invoice) ? $invoice->section_id == $section->id ? 'selected' : '' : '' }}> {{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label for="product" class="control-label">المنتج</label>
                                <select id="product_id" name="product_id" class="form-control">
                                    @if(isset($invoice))
                                        @foreach($products as $product)
{{--                                        <option value="{{ $product->id }}">{{ \App\Product::find($invoice->product_id)->product_name }}</option>--}}
                                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                        @endforeach
                                        @endif
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ التحصيل</label>
                                <input type="text" class="form-control" id="inputName2" name="amount_collection"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       value=" {{isset($invoice) ? $invoice->amount_collection : ''}}"
                                       >
                            </div>

                        </div>


                        {{-- 3 --}}

                        <div class="row">

                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ العمولة</label>
                                <input type="text" class="form-control form-control-lg" id="Amount_Commission"
                                       name="amount_commission" title="يرجي ادخال مبلغ العمولة "
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       required
                                       onkeyup="myFunction()"
                                       value=" {{isset($invoice) ? $invoice->amount_commission : ''}}"
                                >
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الخصم</label>
                                <input type="text" class="form-control form-control-lg" id="discount" name="discount"
                                       title="يرجي ادخال مبلغ الخصم "
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       value=0 required
                                        onkeyup="myFunction()"
                                       value=" {{isset($invoice) ? $invoice->discount : ''}}">

                            </div>


                            <div class="col">
                                <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                                <select name="rate_vat" id="rate_vat" class="form-control" onchange="myFunction()">
                                    <!--placeholder-->
                                    <option value="" selected disabled>حدد نسبة الضريبة</option>
                                    <option value="5%" {{isset($invoice) ? $invoice->rate_vat =='5%' ? 'selected' :'' :''  }}>5%</option>
                                    <option value="10%" {{isset($invoice) ? $invoice->rate_vat =='10%' ? 'selected' :'' :''  }}>10%</option>
                                </select>
                            </div>

                        </div>

                        {{-- 4 --}}
                        <div class="row">


                            <div class="col">
                                <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                <input type="text" class="form-control" id="value_vat" name="value_vat" readonly
                                       value="{{isset($invoice) ? $invoice->value_vat : ''}}">
                                <input type="hidden" name="id" value="{{isset($invoice) ? $invoice->id : ''}}">

                            </div>


                            <div class="col">
                                <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                                <input type="text" class="form-control" id="total" name="total" readonly
                                       value=" {{isset($invoice) ? $invoice->total : ''}}">
                            </div>
                        </div>

                        {{-- 5 --}}
                        <div class="row">
                            <div class="col">
                                <label for="exampleTextarea">ملاحظات</label>
                                <textarea class="form-control" id="exampleTextarea" name="note" rows="3">
                                    {{isset($invoice) ? $invoice->notes : ''}}
                                </textarea>
                            </div>
                        </div>
                        <br>

                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                        <h5 class="card-title">المرفقات</h5>
                        @if(isset($attachments))
                            @foreach($attachments as $attach)
                                <h3 class="text-info">{{$attach->file_name}}</h3>

                            @endforeach
                        @endif
                        <div class="col-sm-12 col-md-12">
                            <input name="photo" type="file" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                   data-height="70"

                            value="">


                        </div>
                        <br>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">حفظ البيانات</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>




    <!-- Container closed -->
tent closed -->
@endsection
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


    <script>
        // $('.fc-datepicker').datepicker({
        //     dateFormat: "yy-mm-dd"
        // }
        //
        //
        //
        // )
        $(document).ready(function () {

            $today = ($.format.date(new Date(), 'yyyy-MM-dd'))
            console.log($today)
            $('.fc-today').val($today);
            $('select[name="section_id"]').on('change', function () {
                var SectionId = $(this).val();

                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('section') }}/" + SectionId,
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

        });

    </script>

    <script>
        function myFunction() {

            var Amount_Commission = parseFloat($("#Amount_Commission").val());
            var discount = parseFloat($("#discount").val());
            var rate_vat = parseFloat($("#rate_vat").val());


            var Amount_Commission2 = Amount_Commission - discount;
            console.log(Amount_Commission2)
            console.log(discount)

            if (!Amount_Commission && !discount && !rate_vat) {
                return 1 ;
            } else {
                var intResults = Amount_Commission2 * rate_vat / 100;

                var intResults2 = parseFloat(intResults + Amount_Commission2);

                sumq = parseFloat(intResults).toFixed(2);

                sumt = parseFloat(intResults2).toFixed(2);

                $("#value_vat").val(sumq);
                $("#total").val(sumt);
            }
        }
    </script>


@endsection
