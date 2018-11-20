<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;

use App\Reseller;
use App\Portal;

class UserController extends Controller {
        
    public function __construct() {	
	
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        
        return view('WalletAdminPanel.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $roles = Role::pluck('name', 'name')->all();
        $reseller = Reseller::pluck('name', 'name')->all();
        $portal = Portal::pluck('name', 'name')->all();      
        
        return view('WalletAdminPanel.users.create', compact('roles','reseller', 'portal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
                
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $reseller = Reseller::where('name',$request->get('reseller'))->first();
        if($reseller)
            $input['reseller_id'] = $reseller->id;
        
        $portal = Portal::where('name',$request->get('portal'))->first();
        if($portal)
            $input['portal_id'] = $portal->id;
                
        $user = User::create($input);
        $user->assignRole($request->input('roles'));        

        return redirect()->route('users.index')
                        ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $user = User::find($id);        
        $permissions = $user->getAllPermissions()->toArray();
        $reseller = Reseller::find($user->reseller_id);
        $portal = Portal::find($user->portal_id);
        
        return view('WalletAdminPanel.users.show', compact('user', 'permissions', 'reseller', 'portal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $reseller = Reseller::pluck('name', 'name')->all();
        $userReseller = $user->reseller_id ? $user->reseller->name :[];
        $portal = Portal::pluck('name', 'name')->all();
        $userPortal = $user->portal_id ? $user->portal->name :[];
        return view('WalletAdminPanel.users.edit', compact('user', 'roles', 'userRole', 'reseller', 'userReseller', 'portal', 'userPortal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }

        $reseller = Reseller::where('name',$request->get('reseller'))->first();
        $input['reseller_id'] = $reseller ? $reseller->id : Null;
        
        $portal = Portal::where('name',$request->get('portal'))->first();
        $input['portal_id'] = $portal ? $portal->id : Null;

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();


        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
                        ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success', 'User deleted successfully');
    }

    /**
     * Datatable Ajax fetch
     *
     * @return
     */    
    public function dtajax() {
        
        $users = User::select('id', 'name', 'email', 'reseller_id', 'portal_id')->with('reseller','portal')->get();
        
        if($users){
            foreach($users as $user){
                $user->roles = $user->getRoleNames();
                $user->actions = '';
                unset($user->reseller_id);
                unset($user->portal_id);
            }
        }
                    
        $out = datatables()->of($users)->toJson();
                        
        return $out;
        
    }
    
    /**
     * Datatable Ajax fetch
     *
     * @return
     */    
    public function dtajax_reseller($id) {
                        
        $users = User::select('id', 'name', 'email')->where('reseller_id',$id)->get();
        
        if($users){
            foreach($users as $user){
                $user->roles = $user->getRoleNames();
            }
        }
                    
        $out = datatables()->of($users)->toJson();
                        
        return $out;
        
    }

}
