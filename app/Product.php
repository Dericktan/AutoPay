<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
        'name', 'quantity', 'price', 'vendor_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'total' => 'decimal:2'
    ];

    protected $appends = ['supplied_by'];

    protected $hidden = ['vendor'];

    public function getSuppliedByAttribute()
    {
        return $this->vendor;
    }

    public function vendor() {
        return $this->belongsTo('App\Vendor');
    }
}
