<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ApiKey extends Model
{
    public $table = "apikeys";
    
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'api_key', 'portal_id'
    ];
}
