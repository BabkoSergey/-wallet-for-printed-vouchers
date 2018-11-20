<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

use App\VoucherType;

class VoucherTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:voucher-type-list');
        $this->middleware('permission:voucher-type-create', ['only' => ['create','store']]);
        $this->middleware('permission:voucher-type-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:voucher-type-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('WalletAdminPanel.voucherprice.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('WalletAdminPanel.voucherprice.create');
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
//            'name' => 'required|unique:reseller',
            'price' => 'required',
//            'validity' => 'required',
        ]);

        $input = $request->all();
        $vouchertype = VoucherType::create($input);
        
        return redirect()->route('voucherprice.index')
                        ->with('success','Voucher Price created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vouchertype = VoucherType::find($id);        
        return view('WalletAdminPanel.voucherprice.show',compact('vouchertype'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vouchertype = VoucherType::find($id);         
        return view('WalletAdminPanel.voucherprice.edit',compact('vouchertype'));
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
//            'name' => 'required',
            'price' => 'required',
//            'validity' => 'required',
        ]);

        $vouchertype = VoucherType::find($id);
        
        $input = $request->all();        
        $vouchertype->update($input);
        
        return redirect()->route('voucherprice.index')
                        ->with('success','Voucher Type updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        VoucherType::find($id)->delete();        
        
		return redirect()->route('voucherprice.index')
                        ->with('success','Voucher Price has been deleted successfully');
    }
    
    /**
     * Datatable Ajax fetch
     *
     * @return
     */    
    public function dtajax() {
        
//        $vouchertypes = VoucherType::select('id', 'name', 'price', 'validity')->get();
		$vouchertypes = VoucherType::select('id', 'price')->get();
        
        if($vouchertypes){
            foreach($vouchertypes as $vouchertype){                
                $vouchertype->actions = '';
            }
        }
                    
        $out = datatables()->of($vouchertypes)->toJson();
                        
        return $out;
        
    }
    
}