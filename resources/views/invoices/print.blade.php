@extends('layouts.master')
@section('css')
@endsection
@section('css')
    @media print {
    #printPageButton {
    display: none;
    }
    }
@endsection
@section('content')
    <!-- row -->
    <div id="print" class="row row-sm" style="padding: 20px">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice">
                    <div class="card card-invoice">
                        <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title">Invoice</h1>
                            <div class="billed-from">
                                <h6>BootstrapDash, Inc.</h6>
                                <p>201 Something St., Something Town, YT 242, Country 6546<br>
                                    Tel No: 324 445-4544<br>
                                    Email: youremail@companyname.com</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">Billed To</label>
                                <div class="billed-to">
                                    <h6>Juan Dela Cruz</h6>
                                    <p>4033 Patterson Road, Staten Island, NY 10301<br>
                                        Tel No: 324 445-4544<br>
                                        Email: youremail@companyname.com</p>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="tx-gray-600">Invoice Information</label>
                                <p class="invoice-info-row"><span>Invoice No</span> <span>{{$invoice->invoice_number}}</span></p>
                                <p class="invoice-info-row"><span>Issue Date:</span> <span>{{$invoice->invoice_date}}</span></p>
                                <p class="invoice-info-row"><span>Issue Date:</span> <span>{{$invoice->due_date}}</span></p>
                                <p class="invoice-info-row"><span>Project ID</span> <span>{{$invoice->section->section_name}}</span></p>

                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                <tr>
                                    <th class="wd-20p">#</th>
                                    <th class="wd-40p">{{__('product')}}</th>
                                    <th class="tx-center">{{__('Amount_collection')}}</th>
                                    <th class="tx-center">{{__('Amount_commission')}}</th>
                                    <th class="tx-right">{{__('total')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{$invoice->id}}</td>
                                    <td>{{$invoice->product->product_name}}</td>
                                    <td>${{$invoice->amount_collection}}</td>
                                    <td>${{$invoice->amount_commission}}</td>
                                    <td>${{ (int) $invoice->amount_collection + $invoice->amount_commission}}</td>
                                </tr>

                                <tr>
                                    <td class="valign-middle" colspan="2" rowspan="4">
                                        <div class="invoice-notes">
                                            <label class="main-content-label tx-13">{{$invoice->note}}</label>

                                        </div><!-- invoice-notes -->
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tx-right">{{__('value vat')}} {{$invoice->rate_vat}}</td>
                                    <td class="tx-right" colspan="2">{{$invoice->value_vat}}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right">{{__('discount')}}</td>
                                    <td class="tx-right" colspan="2"> ${{$invoice->discount}}</td>
                                </tr>
                                <tr>
                                    <td class="tx-right tx-uppercase tx-bold tx-inverse">{{__('total a')}}</td>
                                    <td class="tx-right" colspan="2">
                                        <h4 class="tx-primary tx-bold">${{$invoice->total}}</h4>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mg-b-40">

                        <a id="printPageButton" onclick="printFunc()" class="btn btn-danger float-left mt-3 mr-2">
                            <i class="mdi mdi-printer ml-1"></i>{{__('Print')}}
                        </a>

                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->


    <!-- main-content closed -->
@endsection
@section('js')
    <script>
        function printFunc(el){
            var restorepage = $('body').html();
            var printcontent = $('#print').clone();
            $('body').empty().html(printcontent);
            window.print();
            $('body').html(restorepage);
        }
    </script>
    <script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
@endsection
