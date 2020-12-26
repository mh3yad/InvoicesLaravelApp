<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Invoice_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;


class InvoiceAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     *
     */
    public function addAttachment(Request $request){
        if($request->hasFile('file_name')){
        $file_name = $request->file('file_name')->getClientOriginalName();
//        dd($file_name);
        $attach = Invoice_attachment::create([
            'file_name'=>$request->file('file_name')->storeAs($request->invoice_number,$file_name),
            'invoice_number' => $request->invoice_number,
            'invoice_id' => $request->invoice_id,
            'Created_by' => auth()->user()->name,

        ]);
            $attach->update([
                'file_name'=>$file_name
            ]);
    }

    session()->flash('add-attachment','attachment has been addedd successfully');
    return  back();
}


    public function download($invoice_number,$file_name)
    {
        return Storage::disk('mine')->download($invoice_number."/".$file_name);
    }
    public function delete($id,$invoice_number){
        $id  = Invoice_attachment::find($id);
        Storage::disk('mine')->delete($invoice_number."/".$id->file_name);
        $id->delete();
        session()->flash('delete-attach','attachment has been deleted successfully');
        return back();
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice_attachment  $invoice_attachment
     * @return \Illuminate\Http\Response
     */

}
