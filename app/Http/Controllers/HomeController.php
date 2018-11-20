<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use DB;

use App\Http\Controllers\SettingsController;
use App\Requests;

class HomeController extends Controller
{
    private $settings;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SettingsController $settings)
    {        
        $this->middleware('auth');
        $this->settings = $settings;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_request = Requests::where('user_id',Auth::user()->id)->first();        
        if($user_request){
            $user_request->request = json_decode($user_request->request);
        }
        $is_confirm_portal = (!$this->settings->get_value('portal-confirmation') || $this->settings->get_value('portal-confirmation') == 'yes') ? true : false;
        
        return view('home', compact('user_request','is_confirm_portal'));
    }    
    
    /**
     * Show the portal request.
     *
     * @return \Illuminate\Http\Response
     */
    public function portal_request()
    {
        if( Auth::user()->portal)
            return redirect('/portalpanel');
        
        $user_request = Requests::where('user_id',Auth::user()->id)->first();        
        if($user_request){
            $user_request->request = json_decode($user_request->request);
        }
        return view('portal_request', compact('user_request'));
        
    }    
    
}
