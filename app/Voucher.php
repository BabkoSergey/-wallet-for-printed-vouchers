<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Voucher extends Model
{
    
    public $table = "voucher";
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'voucher', 'status', 'reseller_id', 'seller_id', 'user_id', 'reference', 'expire', 'price', 'seller_host','is_printed'
    ];
    
     /**
     * Many to one relationship with album model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reseller()
    {                
        return $this->hasOne('App\Reseller','id','reseller_id');       
    }
    
    /**
     * Many to one relationship with album model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
//    public function voucherType()
//    {                
//        return $this->hasOne('App\VoucherType','id','type_id');       
//    }
    
}
