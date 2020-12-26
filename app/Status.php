<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $guarded = [];
    public function invoice(){
        return $this->hasMany(Invoice::class);
    }
    public function invoice_details(){
        return $this->hasMany(Invoices_detail::class);
    }
}
