<?php

namespace App\Http\Controllers;


use App\Exports\UsersExport;
use App\Invoice;
use App\Invoice_attachment;
use App\Invoices_detail;
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

    public function reportInvoiceRequest(Request $request){
       if($request->invoiceNumber){

           $invoices = Invoice::where('invoice_number',$request->invoiceNumber)->get();
           return json_encode($invoices);

       }else{

           $invoices = Invoice::where('status_id',$request->invoiceType)->whereBetween('invoice_date',[date($request->from_date),date($request->to_date)])->get();
           return json_encode($invoices);
       }
    }



    public function export()
    {
        return Excel::download(new UsersExport, 'invoices.xlsx');
    }

    public function getproducts($id)
    {
        $products = Section::find($id)->products;
        return json_encode($products);
    }

    public function email()
    {


        Mail::to('mh3yad@gmail.com')->send(new Mailer());
    }

    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $sections = Section::all();
        $products = Product::all();
        $invoices = Invoice::all();


        return view('invoices.index', compact('invoices','sections', 'products','invoice_attachments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::all();
        $products = Product::all();

        return view('invoices.create', compact('sections', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        if ($request->hasFile('photo')){
            $invoice_id = Invoice::latest()->first()->id;
            $file_name=$request->file('photo')->getClientOriginalName();
            $attach = Invoice_attachment::updateOrCreate(
                ['id'=>$request->id],
                [
                'file_name'=>$request->file('photo')->storeAs($request->invoice_number,$file_name),
                'invoice_number'=>$request->invoice_number,
                'Created_by'=>auth::user()->name,
                'invoice_id'=>$invoice_id
            ]);
            // update file name
            $attach->update([
                'file_name'=>$file_name
            ]);
            // move pic
//            $request->photo->move(, $file_name);
        }
        if($invoice->wasChanged()){
            session()->flash('Edit', 'تم تعديل الفاتورة بنجاح');
        }elseif($invoice->wasRecentlyCreated) {
            session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        }else{
            session()->flash('Asdd', 'تم اضافة الفاتورة بنجاح');
        }
        Notification::route('mail', 'mh3yad0@gmail.com')
            ->notify(new InvoiceCreate($invoice));
        return redirect('invoices');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::findOrfail($id);
        $details  = Invoices_detail::where('invoice_id',$invoice->id)->get();
        $attachments  = Invoice_attachment::where('invoice_id',$invoice->id)->get();

        return view('invoices.invoice_details',compact('invoice','attachments','details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $sections = Section::all();
        $products =Section::find($invoice->id)->products;
        $attachments = Invoice_attachment::where('invoice_id',$invoice->id)->get();

        return view('invoices.create',compact('invoice','sections','products','attachments'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
        return redirect('invoices');
    }

    public function archive($invoice)
    {
        $invoice = Invoice::find($invoice);
        $invoice->delete();
        session()->flash('archive','invoice archived successfully');

        return redirect('invoices');
    }
    public function  archive_view(){
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.archive',compact('invoices'));
    }
    public function archive_restore($invoice){
        Invoice::withTrashed()->find($invoice)->restore();
        session()->flash('restored','invoice restored successfully');
        return redirect('invoices');
    }

    public function  status_show($id){
        $invoice = Invoice::find($id);
        return view('invoices.status_show',compact('invoice'));
    }
    public function status_update($id,Request  $request){
        $invoice = Invoice::find($id);
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
        return redirect('invoices');
    }

    public function paid(){
        $invoices = Invoice::where('status_id',3)->get();
        return view('invoices.paid',compact('invoices'));
    }
    public function unpaid(){
        $invoices = Invoice::where('status_id',1)->get();
        return view('invoices.unpaid',compact('invoices'));
    }
    public function partial(){
        $invoices = Invoice::where('status_id',2)->get();

        return view('invoices.partial',compact('invoices'));
    }

    public function print($id){
        $invoice = Invoice::find($id);
        return view('invoices.print ',compact('invoice'));
    }

    public function reportInvoice(){
        $status = Status::all();
        return view('reports.invoices',compact('status'));
    }
    public function reportCustomers(){
        return view('reports.customers');
    }



}
