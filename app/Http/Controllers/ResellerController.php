<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

use App\Reseller;

class ResellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:reseller-list');
        $this->middleware('permission:reseller-create', ['only' => ['create','store']]);
        $this->middleware('permission:reseller-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:reseller-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('WalletAdminPanel.resellers.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('WalletAdminPanel.resellers.create');
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
            'name' => 'required|unique:reseller',
            'address' => 'required',
            'status' => 'required',
        ]);

        $input = $request->all();
        $reseller = Reseller::create($input);
        
        return redirect()->route('resellers.index')
                        ->with('success','Reseller created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reseller = Reseller::find($id);        
        return view('WalletAdminPanel.resellers.show',compact('reseller'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reseller = Reseller::find($id);        
        return view('WalletAdminPanel.resellers.edit',compact('reseller'));
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
            'address' => 'required',
            'status' => 'required',
        ]);

        $reseller = Reseller::find($id);
        
        $input = $request->all();        
        $reseller->update($input);
        
        return redirect()->route('resellers.index')
                        ->with('success','Reseller updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $reseller = Reseller::find($id);        
        $reseller->update(['status'=>'deleted']);
        return redirect()->route('resellers.index')
                        ->with('success','Reseller has sold vouchers. Reseller set status "deleted" successfully');
        
        DB::table("reseller")->where('id',$id)->delete();
        return redirect()->route('resellers.index')
                        ->with('success','Reseller deleted successfully');
    }
    
    /**
     * Datatable Ajax fetch
     *
     * @return
     */    
    public function dtajax() {
        
        $resellers = Reseller::select('id', 'name', 'address', 'status')->get();
        
        if($resellers){
            foreach($resellers as $reseller){                
                $reseller->actions = '';
            }
        }
                    
        $out = datatables()->of($resellers)->toJson();
                        
        return $out;
        
    }
    
}