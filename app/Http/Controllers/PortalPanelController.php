<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

use Illuminate\Support\Facades\Auth;
use App\Portal;
use App\Voucher;
use App\Reseller;

class PortalPanelController extends Controller
{
                
    function __construct()
    {
        
    }
    
    /**
     * Display a Dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {	        
        if(Auth::user()->portal){
            $total_resellers = Voucher::where('seller_host',Auth::user()->portal->host)->whereNotNull('reseller_id')->distinct('reseller_id')->count('reseller_id');
            $vaucher_count = Voucher::where(['status'=>'activate','seller_host'=>Auth::user()->portal->host])->count();
            $total_users = Voucher::where('seller_host',Auth::user()->portal->host)->whereNotNull('user_id')->distinct('user_id')->count('user_id');

            return view('Portal.dashboard', compact('vaucher_count','total_resellers','total_users'));
        }
        
        return view('Portal.dashboard');
        
    }
    	
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        if(Auth::user()->portal){
            $portal = Portal::find(Auth::user()->portal->id);        
            return view('Portal.edit',compact('portal'));
        }
        
        return redirect('/portalpanel');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $portal_id)
    {
        if( !Auth::user()->portal || Auth::user()->portal->id != $portal_id)
            return redirect('/portalpanel');
        
        $this->validate($request, [
            'name' => 'required',
            'host' => 'required',
        ]);
        
        $portal = Portal::find($portal_id);
        
        if( !$portal)
            return redirect('/portalpanel');
        
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
        
        return redirect('/portalpanel');
    }
    
    /**
     * Display a listing of the Users.
     *
     * @return \Illuminate\Http\Response
     */
    public function voucher_list(Request $request)
    {
        if( !Auth::user()->portal)
            return redirect('/portalpanel');
        
        $resellers = Reseller::pluck('name', 'id')->all();
        
        return view('Portal.vouchers.index', compact('resellers'));
    }
        
    /**
     * Datatable Ajax fetch
     *
     * @return
     */
    public function dtajax(Request $request) {

        if( !Auth::user()->portal)
            return response()->json('User NOT have Permission', 422);
        
        $filters = $request->all();
        $where_arg = ['seller_host'=>Auth::user()->portal->host];        
        
        if (isset($filters['f_status']) && $filters['f_status']!='all'){        
            $where_arg[] = ['status', $filters['f_status']];
        }
                
        if (isset($filters['f_price']) && $filters['f_price']!=0 ){
            $where_arg[] = ['price', '>=', $filters['f_price']];
        }   
        
        if (isset($filters['f_reseller']) && $filters['f_reseller']!='all' ){
            $where_arg[] = ['reseller_id', $filters['f_reseller']];         
        } 
        
        if ( (isset($filters['f_expire']) && !empty($filters['f_expire'])) || (isset($filters['f_expire_between']) && !empty($filters['f_expire_between'])) ){
            $field = $filters['f_date'];
            $from = $to = '';
            if ( isset($filters['f_expire']) && !empty($filters['f_expire']) ){
                $from = $filters['f_expire'];
            }
            if ( isset($filters['f_expire_between']) && !empty($filters['f_expire_between']) ){
                $to = $filters['f_expire_between'];
            }
            
            if($from && $to){                
                $vouchers = Voucher::where($where_arg)->whereBetween($field, [$from." 00:00:00", $to." 23:59:59"])->with(['reseller'])->get();                
            }elseif(!$from && $to){
                $vouchers = Voucher::where($where_arg)->whereBetween($field, ["0000-00-00 00:00:00", $to." 23:59:59"])->with(['reseller'])->get();
            }else{
                $vouchers = Voucher::where($where_arg)->whereDate($field, $from)->with(['reseller'])->get();
            }
            
        }else{
            $vouchers = Voucher::where($where_arg)->with(['reseller'])->get();
        }   
                            
        if ($vouchers) {
            foreach ($vouchers as $voucher) {        
                unset($voucher->reseller_id);
            }
        }

        $out = datatables()->of($vouchers)->toJson();

        return $out;
    }
    
}
