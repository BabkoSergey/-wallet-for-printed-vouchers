<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class VoucherType extends Model
{
    
    public $table = "voucher_types";
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'price'
    ];
             
}
