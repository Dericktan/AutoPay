<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
        'price', 'transaction_id', 'product_id', 'user_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'decimal:2'
    ];

    protected $appends = ['product', 'created_by'];

    protected $hidden = ['productRelation', 'userRelation'];

    public function getProductAttribute()
    {
        return $this->productRelation;
    }

    public function getCreatedByAttribute()
    {
        return $this->userRelation;
    }

    public function productRelation() {
        return $this->belongsTo('App\Product', 'product_id');
    }

    public function userRelation() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
