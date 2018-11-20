<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

use Illuminate\Support\Facades\Auth;

use App\Portal;
use App\User;
use App\Http\Controllers\ApiKeyController;

class PortalController extends Controller
{
    private $apiKey;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(ApiKeyController $apiKey)
    {

        $this->middleware('permission:apikey-create', ['only' => ['create','store']]);
        $this->middleware('permission:apikey-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:apikey-delete', ['only' => ['destroy','disable']]);
        
        $this->apiKey = $apiKey;
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( !Auth::user()->hasPermissionTo('portal-list') )
            return redirect('/adminpanel');
        
        return view('WalletAdminPanel.portal.index');
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('WalletAdminPanel.portal.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:portal',
            'host' => 'required|unique:portal',
            'status' => 'required',
        ]);

        $input = $request->all();        
        
        $new_portal = Portal::create($input);
        
        $this->apiKey->createKey($new_portal->id);
        
        return redirect()->route('portal.index')
                        ->with('success','Portal created successfully');
    }
    
    public function storeByRequest($data, $user_id)
    {
        $data['status'] = 'active';
        
        $new_portal = Portal::create($data);
        
        if($new_portal && $new_portal->id){
            $this->apiKey->createKey($new_portal->id);
            
            $user = User::find($user_id);
            $user->update(['portal_id'=>$new_portal->id]);
            if(!$user->hasRole('portal'))
                $user->assignRole('portal');            
        }
        
        return $new_portal;
    }
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $portal = Portal::find($id);                
        $users = User::where('portal_id',$id)->get()->toArray();
        
        return view('WalletAdminPanel.portal.show',compact('portal', 'users'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $portal = Portal::find($id);        
        return view('WalletAdminPanel.portal.edit',compact('portal'));
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
            'name' => 'required',
            'host' => 'required',
            'status' => 'required'
        ]);
        
        $portal = Portal::find($id);
        
        if($request->get('name') != $portal->name){
            $this->validate($request, [
                'name' => 'unique:portal',                
            ]);
        }
        
        if($request->get('host') != $portal->host){
            $this->validate($request, [
                'host' => 'unique:portal',                
            ]);
        }
        
        $input = $request->all();        
        $portal->update($input);
        
        return redirect()->route('portal.index')
                        ->with('success','Portal updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        Portal::find($id)->delete();
        
        return redirect()->route('portal.index')
                        ->with('success', 'Portal deleted successfully');        
    }
    
    /**
     * Disable the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function disable($id)
    {
        
        $portal = Portal::find($id);  
        $portal->update(['status'=>'disabled']);
        
        return redirect()->route('portal.index')
                        ->with('success','Portal set status "disabled" successfully');        
    }
    
    /**
     * Datatable Ajax fetch
     *
     * @return
     */    
    public function dtajax() {
        
        if( !Auth::user()->hasPermissionTo('portal-list') )
            return response()->json('Access Denied', 422);
        
        $portals = Portal::select('id','name', 'host', 'description', 'status')->get();
        
        if($portals){
            foreach($portals as $portal){                
                $portal->actions = '';
            }
        }
                    
        $out = datatables()->of($portals)->toJson();
                        
        return $out;
        
    }
   
}