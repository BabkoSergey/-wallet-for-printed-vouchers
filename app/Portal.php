<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Portal extends Model
{
    public $table = "portal";
    
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'name', 'host', 'description', 'status'
    ];
}
