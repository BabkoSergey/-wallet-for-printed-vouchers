<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

use App\Settings;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function portal_settings(Request $request)
    {
        if( !Auth::user()->hasPermissionTo('portal-create') )
            return redirect('/adminpanel');
        
        $settings = Settings::where('key', 'portal-confirmation')->first();
        if(!$settings)
            $settings = $this->add_key('portal-confirmation', 'yes');
                
        return view('WalletAdminPanel.settings.portal',compact('settings'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [            
            'value' => 'required',
        ]);
        
        $setting = Settings::find($id);
        
        $input = $request->all();        
        $setting->update($input);
        
        $type = $request->get('route');
        
        return redirect(url('adminpanel/settings_'.$type))
                        ->with('success','Settings updated successfully!');
    }    
    
    private function add_key($key, $value)
    {
        $new_key = Settings::create(['key'=>$key, 'value'=>$value]);        
        
        return $new_key;
    }
    
    public function get_value($key)
    {
        $setting = Settings::where('key', $key)->first();        
        
        if(!$setting)
            return NULL;
        
        return $setting->value;
    }
    
    
}