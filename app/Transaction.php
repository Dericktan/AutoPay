<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 
        'total', 'user_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'total' => 'decimal:2'
    ];

    protected $appends = ['details'];

    protected $hidden = ['transaction_detail'];

    public function getDetailsAttribute()
    {
        return $this->transaction_detail;
    }

    public function transaction_detail() {
        return $this->hasMany('App\TransactionDetail');
    }
}
