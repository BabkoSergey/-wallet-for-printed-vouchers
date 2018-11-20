<?php

namespace App\Http\Controllers;

use App\Voucher;
use Illuminate\Http\Request;
use App\Reseller;
use App\VoucherType;
use App\Portal;

use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct() {
        $this->middleware('permission:voucher-list', ['only' => ['index','dtajax','show']]);
        $this->middleware('permission:voucher-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:voucher-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:voucher-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $resellers = Reseller::pluck('name', 'id')->all();
        $providers = Portal::pluck('host', 'id')->all();
        return view('WalletAdminPanel.vouchers.index', compact('resellers', 'providers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $reseller = Reseller::pluck('name', 'name')->all();
	$vouchertype = VoucherType::pluck('price', 'price')->all();
        
        return view('WalletAdminPanel.vouchers.create', compact('reseller','vouchertype'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        request()->validate([
            'count' => 'required|numeric',
            'vouchertype'=>'required'
        ]);

        $input['status'] = 'sale';
        $input['expire'] = ($request->get('activation_expired') ? $request->get('activation_expired') : NULL );
        $input['price'] = $request->get('vouchertype');

        for ($i = 0; $i < request()->get('count'); $i++) {
            while (true) {
                $voucher = $this->randomKey(14,'d');
                if (!Voucher::where("voucher", $voucher)->count()) {                    
                    $input['voucher'] = $voucher;
                    break;
                }                
            }
            while (true) {                
                $refer = $this->randomKey(7,'d').$this->randomKey(1,'A').$this->randomKey(4,'A,d');
                if (!Voucher::where("reference", $refer)->count()) {                    
                    $input['reference'] = $refer;
                    break;
                }
            }
            Voucher::create($input);
        }

        return redirect()->route('vouchers.index')
                        ->with('success', 'Vouchers created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request) {
        return redirect()->route('vouchers.index');        
    }
    
    /**
     * Display the Voucher to print vertion resource.
     *
     * @param  $id     
     */
    public function voucher_show($id) {
        
        if( !Auth::user()->hasPermissionTo('voucher-print') )
            return redirect('/adminpanel/vouchers');
        
        $voucher = Voucher::find($id);
        
        if(!$voucher || $voucher->status != 'sale')
            return redirect('/adminpanel/vouchers');
        
        $dates = [
            'date' => date('d/m/Y', strtotime($voucher->created_at)),
            'time' => date('H:i', strtotime($voucher->created_at)),
        ];
               
        return view('voucher', compact('voucher', 'dates'));
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {
        return redirect()->route('vouchers.index'); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voucher $voucher) {
        request()->validate([
            'voucher' => 'required',
            'status' => 'required',
        ]);


        $voucher->update($request->all());


        return redirect()->route('vouchers.index')
                    ->with('success', 'Voucher updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        
        $voucher = Voucher::find($id);
        
        if($voucher && $voucher->status == 'sale'){
            Voucher::find($id)->delete();
            return redirect()->route('vouchers.index')
                ->with('success', 'Voucher deleted successfully');
        }
        
        return redirect()->route('vouchers.index');                        
    }

    /**
     * Datatable Ajax fetch
     *
     * @return
     */
    public function dtajax(Request $request) {
        
        
        $filters = $request->all();
        $where_arg = [];        
        
         if (isset($filters['f_status']) && $filters['f_status']!='all'){
            $where_arg[] = ['status', $filters['f_status']];
        }
        
        if (isset($filters['f_is_print']) && $filters['f_is_print']!='all' ){
            $where_arg[] = $filters['f_is_print'] == 'yes' ? ['is_printed', true] : ['is_printed', false];        
        }        
        
        if (isset($filters['f_price']) && $filters['f_price']!=0 ){
            $where_arg[] = ['price', '>=', $filters['f_price']];         
        }    
        
        if (isset($filters['f_privider']) && $filters['f_privider']!='all' ){            
            $where_arg[] = ['seller_host',  Portal::find($filters['f_privider'])->host];         
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
                $voucher->actions = '';
                unset($voucher->reseller_id);
            }
        }

        $out = datatables()->of($vouchers)->toJson();

        return $out;
    }
    
    private function randomKey($length,$type='') {
            $key = '';
            
            switch ($type){
                case 'd': 
                    $pool = array_merge(range(0,9));
                    break;
                case 'a': 
                    $pool = array_merge(range('a', 'z'));
                    break;
                case 'A': 
                    $pool = array_merge(range('A', 'Z'));
                    break;
                case 'A,a': 
                    $pool = array_merge(range('a', 'z'), range('A', 'Z'));
                    break;
                case 'A,d': 
                    $pool = array_merge(range(0,9), range('A', 'Z'));
                    break;
                case 'a,d': 
                    $pool = array_merge(range(0,9), range('a', 'z'));
                    break;
                default :
                    $pool = array_merge(range(0,9), range('a', 'z'), range('A', 'Z'));
                    break;
            }
            
            for($i=0; $i < $length; $i++) {
                $key .= $pool[mt_rand(0, count($pool) - 1)];
            }
            
            return $key;
        }

    public function hasExpire($id){
        
        $voucher = Voucher::find($id);
        
        if($voucher)
            $voucher->update(['status'=>'overdue']);
    }
    
    public function hasActivate($id, $user, $provider){
        
        $voucher = Voucher::find($id);
        
        if($voucher)
            $voucher->update(['status'=>'activate','user_id'=>$user, 'seller_host'=>$provider]);
    }
}
