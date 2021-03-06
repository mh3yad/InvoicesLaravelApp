@extends('layouts.master')
<title>الأقسام</title>
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

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">المنتجات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="modal" id="modaldemo1">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">اضافة منتج</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{route('products.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div>

                            <label for="">اسم المنتج</label>
                            <input type="text" placeholder="ادخل اسم القسم " name="product_name" class="form-control">
                            <label for="">القسم </label>
                            <select class="form-control form-control"
                                    name="section">
                                @foreach($sections as $section)
                                    <option value="{{$section->id}}">{{$section->section_name}}</option>
                                    @endforeach
                            </select>
                            <label for="">ملاحظات</label>
                            <textarea placeholder="ادخل الملاحظات " name="description" class="form-control"></textarea>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">اضافة</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">الغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 col-md-4">
            <div class="card custom-card">
                <div class="card-body">
                    <div>

                    </div>
                    <a class="btn ripple btn-success" data-target="#modaldemo1" data-toggle="modal" href="">اضافة
                        منتج</a>
                </div>
            </div>
        </div>

    </div>
    <!-- row -->
    <div class="row">


        <div class="col">
            <div class="card mg-b-20">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                            <tr>
                                <th style="width: 60px">#</th>
                                <th class="wd-15p border-bottom-0">اسم المنتج</th>
                                <th class="wd-15p border-bottom-0">القسم</th>
                                <th class="wd-15p border-bottom-0">الوصف</th>
                                <th class="wd-15p border-bottom-0">العمليات</th>

                            </tr>
                            </thead>

                            <tbody>
                            @foreach($products  as $product)
                                <tr>
                                    <td>{{$product->id}}</td>
                                    <td>{{$product->product_name}}</td>
                                    <td>{{$product->section->section_name}}</td>
                                    <td>{{$product->description}}</td>
                                    <td>
                                        <div class="d-flex mr-2">
                                            <div>
                                                <div class="modal" id="modaldemo2">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content modal-content-demo">
                                                            <div class="modal-header">
                                                                <h6 class="modal-title">تعديل المنتج</h6>
                                                                <button aria-label="Close" class="close"
                                                                        data-dismiss="modal" type="button"><span
                                                                        aria-hidden="true">&times;</span></button>
                                                            </div>
                                                            <form action="{{route('products.update',$section->id)}}"
                                                                  method="POST">
                                                                @method("PUT")
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div>

                                                                        <label for="">اسم المنتج</label>
                                                                        <input type="text"
                                                                               value="{{$product->product_name}}"
                                                                               placeholder="ادخل اسم المنتج "
                                                                               name="product_name" class="form-control">
                                                                        <label for="">القسم </label>
                                                                        <select class="form-control form-control"
                                                                                name="section">
                                                                            @foreach($sections as $section)
                                                                                <option value="{{$section->id}}">{{$section->section_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <label for="">ملاحظات</label>
                                                                        <textarea value="" placeholder="ادخل الملاحظات "
                                                                                  name="description"
                                                                                  class="form-control">{{$product->description}}</textarea>


                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn ripple btn-primary"
                                                                            type="submit">تعديل
                                                                    </button>
                                                                    <button class="btn ripple btn-secondary"
                                                                            data-dismiss="modal" type="button">الغاء
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a data-target="#modaldemo2"
                                                   data-toggle="modal" href="">
                                                    <button class="btn-sm btn-primary"> تعديل</button>
                                                </a>
                                            </div>
                                            <div class="mr-2">
                                                <form action="{{route('products.destroy',$section->id)}}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn-sm btn-danger ml-2" type="submit">حذف</button>
                                                </form>
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
    <script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!-- Internal Select2 js-->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <!-- Internal Modal js-->
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>
@endsection

