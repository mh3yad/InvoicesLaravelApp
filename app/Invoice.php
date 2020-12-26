<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @method static where(string $string, $invoiceType)
 */
class Invoice extends Model
{    use SoftDeletes;
    use Notifiable;


    public function section(){
        return $this->belongsTo(Section::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function invoices_details()
    {
        return $this->hasMany('App\Invoices_detail');
    }

    public function invoice_attachments()
    {
        return $this->hasMany(Invoice_attachment::class);
    }
    public function status(){
        return $this->belongsTo(Status::class);
    }

    protected $guarded = [];
    use SoftDeletes;




    public static function boot()
    {
        parent::boot();

        static::deleting(function ($invoices_details) { // before delete() method call this
            $invoices_details->invoices_details()->delete();
            // do the rest of the cleanup...
        });
    }
}
