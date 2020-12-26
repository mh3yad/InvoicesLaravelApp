<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static find($id)
 */
class Section extends Model
{
    protected  $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    // this is a recommended way to declare event handlers
    public static function boot() {
        parent::boot();

        static::deleting(function($section) { // before delete() method call this
            $section->products()->delete();
            // do the rest of the cleanup...
        });
    }
}
