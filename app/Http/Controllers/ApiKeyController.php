<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

use Illuminate\Support\Facades\Auth;

use App\ApiKey;

class ApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $portal_id
     * @return ApiKey
     */
    public function createKey($portal_id)
    {
        while (true) {
            $api_key = $this->randomKey();
            if (!ApiKey::where("api_key", $api_key)->count()) {                                    
                break;
            }                
        }
        
        $new_api_key = ApiKey::create(['api_key'=>$api_key, 'portal_id'=>$portal_id]);
        
        return $new_api_key;
    }
        
    /**
     * Display the specified resource.
     *
     * @param  int  $portal_id
     * @return \Illuminate\Http\Response
     */
    public function get_key($portal_id)
    {
        if( !Auth::user()->hasPermissionTo('apikey-list') )
            return response()->json('NOT Have Permission!', 422);
        
        $api_key = ApiKey::where('portal_id', $portal_id)->first();        
        
        return response()->json($api_key->api_key);                
    }
    
    public function get_key_portal($portal_id)
    {
        if( !Auth::user()->portal || Auth::user()->portal->id != $portal_id)
            return response()->json('NOT Have Permission!', 422);
        
        $api_key = ApiKey::where('portal_id', $portal_id)->first();        
        
        return response()->json($api_key->api_key);                
    }
    
   
    /**
     * Update the specified resource.
     *
     * @param  int  $portal_id
     * @return \Illuminate\Http\Response
     */
    public function change_key($portal_id)
    {
        if( !Auth::user()->hasPermissionTo('apikey-edit') )
            return response()->json('NOT Have Permission!', 422);
        
        $api_key = ApiKey::where('portal_id', $portal_id)->first();       
        
        if(!$api_key)
            return response()->json('API KEY Not Found!', 422);
        
        while (true) {
            $new_key = $this->randomKey();
            if (!ApiKey::where("api_key", $new_key)->count()) {                                    
                break;
            }                
        }
        
        $api_key->update(["api_key" => $new_key]);        
        
        return response()->json($api_key->api_key);                
    }
    
    public function change_key_portal($portal_id)
    {
        if( !Auth::user()->portal || Auth::user()->portal->id != $portal_id)
            return response()->json('NOT Have Permission!', 422);
        
        $api_key = ApiKey::where('portal_id', $portal_id)->first();       
        
        if(!$api_key)
            return response()->json('API KEY Not Found!', 422);
        
        while (true) {
            $new_key = $this->randomKey();
            if (!ApiKey::where("api_key", $new_key)->count()) {                                    
                break;
            }                
        }
        
        $api_key->update(["api_key" => $new_key]);        
        
        return response()->json($api_key->api_key);                
    }
        
    private function randomKey($length = 12) {
            $key = '';
            $pool = array_merge(range(0,9), range('a', 'z'), range('A', 'Z'));
            
            for($i=0; $i < $length; $i++) {
                $key .= $pool[mt_rand(0, count($pool) - 1)];
            }
            
            return $key;
        }
    
}