<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'reseller_id', 'portal_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
    public function portal()
    {                
        return $this->hasOne('App\Portal','id','portal_id');       
    }
    
}
