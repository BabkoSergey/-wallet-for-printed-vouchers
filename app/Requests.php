<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Requests extends Model
{
    public $table = "requests";
    
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'type', 'request', 'status', 'user_id'
    ];
        
}
