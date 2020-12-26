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

        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{route('status_update',$invoice->id)}}" method="post" enctype="multipart/form-data"
                          autocomplete="off">
                        {{ csrf_field() }}

                        {{-- 1 --}}

                        <div class="row">

                            <div class="col">
                                <label for="inputName" class="control-label">رقم الفاتورة</label>
                                <input type="text" class="form-control" id="inputName" name="invoice_number"
                                       title="يرجي ادخال رقم الفاتورة"
                                       value="{{$invoice->invoice_number}}"  readonly
                                >
                            </div>

                            <div class="col">
                                <label>تاريخ الفاتورة</label>
                                <input class="form-control fc-datepicker fc-today" name="invoice_date" placeholder="YYYY-MM-DD"
                                       type="text" readonly
                                       value="{{$invoice->invoice_date}}"
                                >
                            </div>

                            <div class="col">
                                <label>تاريخ الاستحقاق</label>
                                <input class="form-control fc-datepicker" name="due_date" placeholder="YYYY-MM-DD"
                                       type="text" readonly
                                       value="{{$invoice->due_date}}"
                                >
                            </div>

                        </div>


                        {{-- 2 --}}

                        <div class="row">
                            <div class="col">
                                <label for="inputName" class="control-label">القسم</label>
                                <select id="inputName" name="section_id" class="form-control" readonly>
                                    <!--placeholder-->
                                        <option value="{{$invoice->section_id}}"   selected    > {{ $invoice->section->section_name }}</option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="product_id" class="control-label">المنتج</label>
                                <select id="product_id" name="product_id" class="form-control" readonly>
                                    <option value="{{$invoice->product_id}}"   selected   > {{ $invoice->product->product_name }}</option>

                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ التحصيل</label>
                                <input type="text" class="form-control" id="inputName2" name="amount_collection"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       value="{{$invoice->amount_collection}}
                                           " readonly
                                >
                            </div>

                        </div>


                        {{-- 3 --}}

                        <div class="row">

                            <div class="col">
                                <label for="inputName" class="control-label">مبلغ العمولة</label>
                                <input type="text" class="form-control form-control-lg" id="Amount_Commission"
                                       name="amount_commission" title="يرجي ادخال مبلغ العمولة "
                                       readonly
                                       value="{{$invoice->amount_commission}} "
                                >
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">الخصم</label>
                                <input type="text" class="form-control form-control-lg" id="discount" name="discount"
                                       title="يرجي ادخال مبلغ الخصم "
                                       readonly
                                       value="{{$invoice->discount}}">

                            </div>


                            <div class="col">
                                <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                                <select name="rate_vat" id="rate_vat" class="form-control"  readonly>
                                    <!--placeholder-->
                                    <option value="{{$invoice->rate_vat}}">{{$invoice->rate_vat}}%</option>
                                </select>
                            </div>

                        </div>

                        {{-- 4 --}}
                        <div class="row">


                            <div class="col">
                                <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                <input type="text" class="form-control" id="value_vat" name="value_vat" readonly
                                value="{{$invoice->value_vat}}">
                            </div>


                            <div class="col">
                                <label for="total" class="control-label">الاجمالي شامل الضريبة</label>
                                <input type="text" class="form-control" id="total" name="total" readonly
                                       value="{{$invoice->total}}">
                            </div>
                        </div>

                        {{-- 5 --}}
                        <div class="row">
                            <div class="col">
                                <label for="exampleTextarea">ملاحظات</label>
                                <textarea class="form-control" id="exampleTextarea" name="note" rows="3" readonly>
                                    {{$invoice->notes}}
                                </textarea>
                            </div>
                        </div>

                        <br>
                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                        <h5 class="card-title">المرفقات</h5>

                            @foreach($invoice->invoice_attachments as $attach)
                                <h3 class="text-info">{{$attach->file_name}}</h3>
                            @endforeach

                        <div class="row">
                            <div class="col">
                                <label for="payment_status">
                                    حالة الدفع
                                </label>
                                <select  id="payment_status" name="status_id" class="form-control" >
                                    <option value="2"   selected    > مدفوعة جزئيا</option>
                                    <option value="3"   selected    >مدفوعة كليا </option>
                                </select>
                            </div>
                            <div class="col">

                                <label>تاريخ الدفع</label>
                                <input class="form-control fc-datepicker fc-today"  name="payment_date" placeholder="YYYY-MM-DD"
                                       type="text">
                            </div>
                        </div>

                        <br>
                        <br>
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

            $('.fc-today').val($today);
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

