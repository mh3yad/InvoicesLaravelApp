<?php

namespace App\Http\Controllers;


use App\Exports\UsersExport;
use App\Invoice;
use App\Invoice_attachment;
use App\Invoices_detail;
use App\Notifications\AdminNotify;
use App\Notifications\InvoiceCreate;
use App\Product;
use App\Section;
use App\Status;
use App\User;
use Illuminate\Mail\Mailable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use App\Mail\Mailer;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{


    // Invoices methods
    public function email()
    {
        Mail::to('mh3yad@gmail.com')->send(new Mailer());
    }
    public function index()
    {

        $sections = Section::all();
        $products = Product::all();
        $invoices = Invoice::all();


        return view('invoices.index', compact('invoices','sections', 'products','invoice_attachments'));
    }
    public function create()
    {
        $sections = Section::all();
        $products = Product::all();

        return view('invoices.create', compact('sections', 'products'));
    }
    public function store(Request $request)
    {
        $manager = User::find(3);
        $validata = $request->validate([
            'invoice_number'=>'required|max:60',
            'invoice_date'=>'required|max:60',
            'due_date'=>'required|max:60',
            'product_id'=>'required|max:60',
            'section_id'=>'required|max:60',
            'amount_collection'=>'required|max:60',
            'amount_commission'=>'required|max:60',
            'discount'=>'required|max:60',
            'rate_vat'=>'required|max:60',
            'total'=>'required|max:60',
            'file'=>'required_if:update,false|mimes:pdf,doc,ppt,xls,docx,pptx,xlsx|max:1000'
        ]);
        $invoice = Invoice::updateOrCreate(
            ['id'=>$request->id],
            [
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'product_id' => $request->product_id,
                'section_id' => $request->section_id,
                'amount_collection' => $request->amount_collection,
                'amount_commission' => $request->amount_commission,
                'discount' => $request->discount,
                'rate_vat' => $request->rate_vat,
                'value_vat' => $request->value_vat,
                'total' => $request->total,
                'note' => $request->note,
                'user' => auth::user()->name,
            ]);

        $invoice_id = Invoice::latest()->first()->id;

        Invoices_detail::updateOrCreate(
            ['id'=>$request->id],
            [
                'invoice_id' => $invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product_id,
                'Section' => $request->section_id,
                'note' => $request->note,
                'user' => auth::user()->name,
            ]);

        // upload attachments
        if ($request->hasFile('file')){
            $invoice_id = Invoice::latest()->first()->id;
            $file_name=$request->file('file')->getClientOriginalName();
            $attach = Invoice_attachment::updateOrCreate(
                ['id'=>$request->id],
                [
                    'file_name'=>$request->file('file')->storeAs($request->invoice_number,$file_name),
                    'invoice_number'=>$request->invoice_number,
                    'Created_by'=>auth::user()->name,
                    'invoice_id'=>$invoice_id
                ]);
            $attach->update([
                'file_name'=>$file_name
            ]);

        }
        if($request->id){
            session()->flash('Edit', 'تم تعديل الفاتورة بنجاح');
        }elseif($invoice->wasRecentlyCreated) {
            session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        }
//        session()->flash('Edit', 'تم تعديل الفاتورة بنجاح');
        $delay = now()->addMinutes(10);
        Notification::route('mail', 'mh3yad0@gmail.com')->notify((new InvoiceCreate($invoice))->delay($delay));
        $manager->notify((new AdminNotify($invoice))->delay($delay));
        return redirect(app()->getLocale().'/invoices');
    }
    public function show($d,$id)
    {
        $invoice = Invoice::find($id);
//        dd($id);
        $details  = Invoices_detail::where('invoice_id',$invoice->id)->get();
        $attachments  = Invoice_attachment::where('invoice_id',$invoice->id)->get();

        return view('invoices.invoice_details',compact('invoice','attachments','details'));
    }
    public function edit($d,Invoice $invoice)
    {
        $sections = Section::all();
        $products = Section::find($invoice->section_id)->products;
        $attachments = Invoice_attachment::where('invoice_id',$invoice->id)->get();

        return view('invoices.create',compact('invoice','sections','products','attachments'));
    }
    public function destroy($d,$id)
    {
//
        $invoice = Invoice::find($id);

        // to remove it from archived
        if(is_null($invoice)) {
            $invoice = Invoice::withTrashed()->find($id);
            Storage::disk('mine')->deleteDirectory($invoice->invoice_number);
            $invoice->forceDelete();
        }else{
            Storage::disk('mine')->deleteDirectory($invoice->invoice_number);
            $invoice->forceDelete();
        }

        session()->flash('forceDelete','تم حذف الفاتورة نهائيا');
        return redirect(app()->getLocale().'/invoices');
    }

    // notification method
    public function  notificationDetails($notification){
        $notification = auth()->user()->notifications()->find($notification);
        $notification->markAsRead();
        return redirect($notification->data['url']);
    }

    // report methods
    public function reportInvoice(){
        $status = Status::all();
        return view('reports.invoices',compact('status'));
    }
    public function reportInvoiceRequests(Request $request){
       if($request->invoiceNumber){
           $status = Status::all();
           $invoices = Invoice::where('invoice_number',$request->invoiceNumber)->get();
           return view('reports.invoices',compact('invoices','status'));

       }else{
           $status = Status::all();
           $invoices = Invoice::where('status_id',$request->invoiceType)->whereBetween('invoice_date',[date($request->from_date),date($request->to_date)])->get();
           return view('reports.invoices',compact('invoices','status'));
       }
    }
    public function reportCustomers(){
        $sections  = Section::all();
        return view('reports.customers',compact('sections'));
    }
    public function reportCustomersQuery(Request $request){
        $sections  = Section::all();
        if(isset($request->from_date) && isset($request->to_date)  ){

            $invoices = Invoice::where('section_id',$request->section_id)->where('product_id',$request->product_id)->whereBetween('invoice_date',[date($request->from_date),date($request->to_date)])->get();;
            return view('reports.customers',compact('invoices','sections'));
        }else{
            $invoices = Invoice::where('section_id',$request->section_id)->where('product_id',$request->product_id)->get();;
            return view('reports.customers',compact('invoices','sections'));
        }
    }

    // export excel method
    public function export()
    {
        return Excel::download(new UsersExport, 'invoices.xlsx');
    }

    // AJAX get products
    public function getproducts($d,$id)
    {
        $products = Section::find($id)->products;
        return json_encode($products);
    }

    // send Email method



    // archive methods
    public function archive($d,$invoice)
    {
        $invoice = Invoice::find($invoice);
        $invoice->delete();
        session()->flash('archive','invoice archived successfully');

        return redirect(app()->getLocale().'/invoices');
    }
    public function archive_view(){
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.archive',compact('invoices'));
    }
    public function archive_restore($d,$invoice){
        Invoice::withTrashed()->find($invoice)->restore();
        session()->flash('restored','invoice restored successfully');
        return redirect(app()->getLocale().'/invoices');
    }

    // status of invoices methods
    public function status_show($d,$id){
        $invoice = Invoice::find($id);
        return view('invoices.status_show',compact('invoice'));
    }
    public function status_update($d,$id,Request  $request){
        $invoice = Invoice::find($id);
        $request->validate([
            'payment_date'=>'required',
            'status_id'=>'required',

            'invoice_number'=>'required',
            'product_id'=>'required',
            'section_id'=>'required',


        ]);
        $invoice->update([
            'payment_date'=>$request->payment_date,
            'status_id'=>$request->status_id
        ]);
        Invoices_detail::create([
            'status_id'=>$request->status_id,
            'invoice_id' => $invoice->id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product_id,
            'Section' => $request->section_id,
            'note' => $request->note,
            'user' => auth::user()->name,

        ]);
        session()->flash('status_update','status updated successfully');
        return redirect(app()->getLocale().'/invoices');
    }

    // paid invoices
    public function paid(){
        $invoices = Invoice::where('status_id',3)->get();
        return view('invoices.paid',compact('invoices'));
    }

    //unpaid invoices
    public function unpaid(){
        $invoices = Invoice::where('status_id',1)->get();
        return view('invoices.unpaid',compact('invoices'));
    }

    // partial paid invoices
    public function partial(){
        $invoices = Invoice::where('status_id',2)->get();

        return view('invoices.partial',compact('invoices'));
    }

    // print invoice method
    public function print($i,$id){
        $invoice = Invoice::find($id);

        return view('invoices.print ',compact('invoice'));
    }







}
