<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Auth;

use App\Requests;
use App\Reseller;
use App\Portal;
use App\User;

class RequestController extends Controller
{
    
    private $settings;
    
    private $portal;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(SettingsController $settings, PortalController $portal)
    {
        $this->settings = $settings;
        $this->portal = $portal;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function portal_index(Request $request)
    {
        if( !Auth::user()->hasPermissionTo('portal-list') )
            return redirect('/adminpanel');
        
        $is_confirmation = !$this->settings->get_value('portal-confirmation') || ($this->settings->get_value('portal-confirmation') == 'yes') ? true : false;
                                 
        return view('WalletAdminPanel.requests.portal',compact('is_confirmation'));
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function portal_show($id)
    {
        $request = Requests::find($id);       
        $request->request = json_decode($request->request);
        $user = User::where('id',$request->user_id)->first();
        $reseller = Reseller::find($user->reseller_id);
        
        
        return view('WalletAdminPanel.requests.portal_show',compact('request', 'user', 'reseller'));
    }
    
    /**
     * Approve the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function portal_approve($id)
    {
        $request = Requests::find($id);   
        
        if($request){
            $request->request = json_decode($request->request);
            
            $is_portal = Portal::where('name',$request->request->name)->orWhere('host',$request->request->host)->first();
            if($is_portal)                
                return redirect()->back()->withErrors(['error'=>'Name or Host already used!']);
          
            $portal = $this->portal->storeByRequest([
                'name' => $request->request->name,
                'host' => $request->request->host,
                'description' => $request->request->description,
            ],$request->user_id);
            
            if($portal)
                Requests::find($id)->delete();
        }
                
        return redirect('adminpanel/requests/portal');
    }
    
    /**
     * Disable the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function portal_disable($id)
    {
        $request = Requests::find($id);       
        
        if($request)            
            $request->update(['status' => 'disabled']);
            
        return redirect('adminpanel/requests/portal');
    }
    
    /**
     * Disable the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function portal_delete($id)
    {        
        Requests::find($id)->delete();
            
        return redirect('adminpanel/requests/portal');
    }
    
        
    /**
     * Datatable Ajax fetch
     *
     * @return
     */    
    public function portal_dtajax() {
                
        if( !Auth::user()->hasPermissionTo('portal-list') )
            return response()->json('Access Denied', 422);
        
        $requests = Requests::where('type','portal')->get();
        
        if($requests){
            foreach($requests as $request){       
                $request->request = json_decode($request->request);
                $request->actions = '';
            }
        }
                    
        $out = datatables()->of($requests)->toJson();
                        
        return $out;
        
    }    
    
    /**
     * Create/Update resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function portal_request_update(Request $request)
    {
        if( Auth::user()->portal)
            return redirect('/portalpanel');
        
        $this->validate($request, [
            'name' => 'required|unique:portal',
            'host' => 'required|unique:portal',
        ]);
        
        $is_confirmation = (!$this->settings->get_value('portal-confirmation') || $this->settings->get_value('portal-confirmation') == 'yes') ? true : false;
        
        $user_request = Requests::where('user_id',Auth::user()->id)->first();
        
        if($is_confirmation){ 
            $request_data = json_encode([
                        'name' => $request->get('name'),
                        'host' => $request->get('host'),
                        'description' => $request->get('description'),
                        ]);
            if($user_request){                
                $data = [
                    'request' => $request_data,
                    'status' => 'pending'
                ];              
                $user_request->update($data);
                
                return redirect('/new_portal')->with('success', 'Request update successfully.');
            }else{
                $data = [
                    'request' => $request_data,
                    'type' => 'portal',
                    'user_id' => Auth::user()->id,                    
                ];                
                Requests::create($data);                
                
                return redirect('/new_portal')->with('success', 'Request send successfully.');
            }                        
        }else{
            if($user_request)
                Requests::find($user_request->id)->delete();
            
            $portal = $this->portal->storeByRequest($request->all(),Auth::user()->id);
            
            if($portal && $portal->id)                
                return redirect('/portalpanel');
            
            return redirect('/new_portal')->withErrors(['error'=>'Error!']);
        }

    }
    
}