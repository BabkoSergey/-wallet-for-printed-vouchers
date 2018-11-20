<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Reseller extends Model
{
    public $table = "reseller";
    
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'status'
    ];
}
