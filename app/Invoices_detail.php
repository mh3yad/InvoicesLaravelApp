<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoices_detail extends Model
{
    public function invoice(){
        return $this->belongsTo('App\Invoice');
    }
    public function status(){
        return $this->belongsTo(Status::class);
    }
        protected $guarded = [];
}
