<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

use App\User;
use App\Reseller;
use App\Voucher;
use App\VoucherType;
use Illuminate\Support\Facades\Auth;

require "../app/Library/dompdf/autoload.inc.php";

use Dompdf\Dompdf;

class WalletPanelController extends Controller
{
    private  $dompdf;
            
    function __construct(Dompdf $dompdf)
    {
        $this->dompdf = $dompdf;
        //$this->middleware('permission:distributor');         
    }
    
    /**
     * Display a Dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$reseller = Reseller::find(Auth::user()->reseller_id);
		$vaucher_count = Voucher::where('reseller_id', Auth::user()->reseller_id)->count();
		$vaucher_count_sold = Voucher::where('reseller_id', Auth::user()->reseller_id)->where('status','sold')->count();
		$vaucher_count_active = Voucher::where('reseller_id', Auth::user()->reseller_id)->where('status','activate')->count();
		$total_users = Voucher::where('reseller_id', Auth::user()->reseller_id)->whereNotNull('user_id')->distinct('user_id')->count('user_id');
        return view('Wallet.dashboard', compact('reseller','vaucher_count','vaucher_count_sold','vaucher_count_active','total_users'));
		
    }
	
	public function reseller(Request $request)
    {
		$reseller = Reseller::find(Auth::user()->reseller_id);  
        return view('Wallet.reseller',  compact('reseller'));
    }
    
    /**
     * Display a listing of the Users.
     *
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request)
    {
        if( !Auth::user()->hasPermissionTo('reseller-user-list') )
            return redirect('/home');
        
        return view('Wallet.users.index');
    }
    
    /**
     * Display a User info.
     *
     * @return \Illuminate\Http\Response
     */
    public function user($id)
    {
        if( !Auth::user()->hasPermissionTo('reseller-user-list') )
            return redirect('/home');
        
        $user = User::find($id);
        
        if(!$user || $user->reseller_id != Auth::user()->reseller_id)
            return redirect('/wallet/users');
        
        return view('Wallet.users.show', compact('user'));
    }
    
    /**
     * Display a User info.
     *
     * @return \Illuminate\Http\Response
     */
    public function user_edit($id)
    {
        if( !Auth::user()->hasPermissionTo('reseller-user-edit') )
            return redirect('/wallet/users');
        
        $user = User::find($id);
        
        if(!$user || $user->reseller_id != Auth::user()->reseller_id)
            return redirect('/wallet/users');
        
        //$roles = Role::pluck('name', 'name')->all();
        $roles = [
            'distributor'=>'distributor',
            'reseller'=>'reseller'
        ];
        
        $userRole = $user->roles->pluck('name', 'name')->all();
        foreach($userRole as $keyUserRole=>$valUserRole){
            if(!in_array($valUserRole,$roles)){
                unset($userRole[$keyUserRole]);
            }
        }

        return view('Wallet.users.edit', compact('user', 'roles', 'userRole'));
    }
    
    /**
     * Datatable Ajax fetch
     *
     * @return
     */    
    public function user_dtajax() {
                
        if( !Auth::user()->hasPermissionTo('reseller-user-list') )
            return response()->json('User NOT have Permission', 422);
        
        $users = User::select('id', 'name', 'email')->where('reseller_id',Auth::user()->reseller_id)->get();
                
        if($users){
            foreach($users as $user){
                $user->roles = $user->getRoleNames();
                $user->actions = '';
                unset($user->reseller_id);
            }
        }
                    
        $out = datatables()->of($users)->toJson();
                        
        return $out;
        
    }
    
     /**
     * Display a listing of the Users.
     *
     * @return \Illuminate\Http\Response
     */
    public function voucher_list(Request $request)
    {
        if( !Auth::user()->hasPermissionTo('reseller-voucher-list') )
            return redirect('/home');
        
        return view('Wallet.vouchers.index');
    }
        
    /**
     * Datatable Ajax fetch
     *
     * @return
     */
    public function dtajax(Request $request) {

        if( !Auth::user()->hasPermissionTo('reseller-voucher-list') )
            return response()->json('User NOT have Permission', 422);
        
        $filters = $request->all();
        $where_arg = [];
        $or_where_arg[] = ['reseller_id',Auth::user()->reseller_id];
        
        if (!isset($filters['f_status']) || $filters['f_status']=='all' || $filters['f_status']=='sale'){
            $where_arg[] = ['status', 'sale'];
        }else{
            $where_arg[] = ['status', 'NOT'];
        }
        if (isset($filters['f_status']) && $filters['f_status']!='all'){
            $or_where_arg[] = ['status', $filters['f_status']];
        }
        
        if (isset($filters['f_is_print']) && $filters['f_is_print']!='all' ){
            $where_arg[] = $filters['f_is_print'] == 'yes' ? ['is_printed', true] : ['is_printed', false];
            $or_where_arg[] = $filters['f_is_print'] == 'yes' ? ['is_printed', true] : ['is_printed', false];
        }        
        
        if (isset($filters['f_price']) && $filters['f_price']!=0 ){
            $where_arg[] = ['price', '>=', $filters['f_price']];
            $or_where_arg[] = ['price', '>=', $filters['f_price']];
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
                $sale_vouchers = Voucher::where($where_arg)->whereBetween($field, [$from." 00:00:00", $to." 23:59:59"])->with(['reseller'])->get();
                $reseller_vouchers = Voucher::where($or_where_arg)->whereBetween($field, [$from." 00:00:00", $to." 23:59:59"])->with(['reseller'])->get();
            }elseif(!$from && $to){
                $sale_vouchers = Voucher::where($where_arg)->whereBetween($field, ["0000-00-00 00:00:00", $to." 23:59:59"])->with(['reseller'])->get();
                $reseller_vouchers = Voucher::where($or_where_arg)->whereBetween($field, ["0000-00-00 00:00:00", $to." 23:59:59"])->with(['reseller'])->get();
            }else{
                $sale_vouchers = Voucher::where($where_arg)->whereDate($field, $from)->with(['reseller'])->get();
                $reseller_vouchers = Voucher::where($or_where_arg)->whereDate($field, $from)->with(['reseller'])->get();                 
            }
            
        }else{
            $sale_vouchers = Voucher::where($where_arg)->with(['reseller'])->get();
            $reseller_vouchers = Voucher::where($or_where_arg)->with(['reseller'])->get();
        }   
        
        $vouchers = $sale_vouchers->merge($reseller_vouchers);
        
                    
        if ($vouchers) {
            foreach ($vouchers as $voucher) {
                $voucher->actions = '';
                $voucher->checkbox = '';
                unset($voucher->reseller_id);
            }
        }

        $out = datatables()->of($vouchers)->toJson();

        return $out;
    }
    
    /**
     * Display the Voucher to print vertion resource.
     *
     * @param  $id     
     */
    public function vouchers_actions($action, $ids) {
        
        $voucher_ids = [];
        if($ids)
            $voucher_ids = explode (',', $ids);
        
        if(empty($voucher_ids))
            return response()->json('Nothing Set!', 422);            
                
        switch ($action){
            case 'print':
                if( !Auth::user()->hasPermissionTo('voucher-print') )
                    return response()->json('NOT Have Permission!', 422);
                
                $solded_vouchers = Voucher::whereIn('id',$this->voucher_mas_print_rfresh($voucher_ids))->get();   
                break;
            case 'sold':
                if( !Auth::user()->hasPermissionTo('reseller-voucher-list') )
                    return response()->json('NOT Have Permission!', 422);
                
                $solded_vouchers = Voucher::whereIn('id',$this->vouchers_mas_sold($voucher_ids))->get();                
                break;
            case 'refund':                
                if( !Auth::user()->hasPermissionTo('reseller-voucher-edit') )
                    return response()->json('NOT Have Permission!', 422);
                
                $solded_vouchers = Voucher::whereIn('id',$this->vouchers_mas_refund($voucher_ids))->get();
                break;
            default :
                return response()->json('NOT Have Permission!', 422);
        }
        
        $out = datatables()->of($solded_vouchers)->toJson();

        return $out;
        
    }
    
    
    /**
     * Display the Voucher to print vertion resource.
     *
     * @param  $ids     
     */
    public function voucher_print($ids) {
        
        if( !Auth::user()->hasPermissionTo('voucher-print') )
            return redirect('/wallet/vouchers');
        
        $voucher_ids = [];
        if($ids)
            $voucher_ids = explode (',', $ids);
        
        if(empty($voucher_ids))
            return redirect('/wallet/vouchers');
        
        if(is_array($voucher_ids)){
            foreach($voucher_ids as $key=>$id){
                $voucher = Voucher::find($id);

                if( !$voucher || !in_array($voucher->status, array('sale','sold')))
                    unset ($voucher_ids[$key]);
            }
            $vouchers = Voucher::whereIn('id',$voucher_ids)->get();
        }else{
            return redirect('/wallet/vouchers');
        }
        
        if(!$vouchers)
            return redirect('/wallet/vouchers');
        
        foreach($vouchers as $key=>$voucher){
            $dates[$key] = [
                'date' => date('d/m/Y', strtotime($voucher->created_at)),
                'time' => date('H:i', strtotime($voucher->created_at)),
            ];
        }
        
        // Get HTML
        $this->dompdf->loadHtml(view('voucher_view', ['vouchers'=>$vouchers, 'dates'=>$dates]));
        
        //Setup
        $this->dompdf->setPaper('A4', 'portal');
        $this->dompdf->set_option('defaultFont', 'sans-serif');
        $this->dompdf->set_option('isRemoteEnabled', true);        

        // Render the HTML as PDF
        $this->dompdf->render();

        // Output the generated PDF (1 = download and 0 = preview)
        return $this->dompdf->stream("vouchers-".date('y-m-d-H:i:s'), array("Attachment"=>0));        
                         
    }
    
    /**
     * Refresh the Voucher to print status.
     *
     * @param  $id     
     */
    public function voucher_print_rfresh($id) {
                        
        if( !Auth::user()->hasPermissionTo('voucher-print') )
            return response()->json('NOT Have Permission!', 422);
        
        $voucher = Voucher::find($id);
	if( !$voucher || !in_array($voucher->status, array('sale','sold')))
            return response()->json('Voucher NOT Found!', 422);
        
        $voucher->update(['is_printed'=>true]);
                       
        return response()->json($voucher);                
    }

    public function voucher_mas_print_rfresh($ids) {
                        
        if(is_array($ids)){
            foreach($ids as $key=>$id){
                $voucher = Voucher::find($id);

                if( !$voucher || !in_array($voucher->status, array('sale','sold')))
                    unset ($ids[$key]);

                $voucher->update(['is_printed'=>true]);

            }
            return $ids;        
        }else{
            return [];
        }         
    }
    

    /**
     * Display the Voucher to print vertion resource.
     *
     * @param  $id     
     */
    public function voucher_sold($id) {
        
        if( !Auth::user()->hasPermissionTo('reseller-voucher-list') )
            return response()->json('NOT Have Permission!', 422);
        
        $voucher = Voucher::find($id);
        
        if(!$voucher)
            return response()->json('Voucher NOT Found!', 422);
        
        if($voucher->status != 'sale')
            return response()->json('Voucher has "'. $voucher->status .'"!', 422);
   
	$input['status'] = 'sold';
	$input['seller_id'] = Auth::user()->id;
	$input['reseller_id'] = Auth::user()->reseller_id;
        $voucher->update($input);
        
        return response()->json($voucher);        
        
    }
    
    private function vouchers_mas_sold($ids) {
        
        if(is_array($ids)){
            foreach($ids as $key=>$id){
                $voucher = Voucher::find($id);

                if(!$voucher || $voucher->status != 'sale')
                    unset ($ids[$key]);

                $input['status'] = 'sold';
                $input['seller_id'] = Auth::user()->id;
                $input['reseller_id'] = Auth::user()->reseller_id;
                $voucher->update($input);

            }
            return $ids;        
        }else{
            return [];
        }        
    }
	
    public function voucher_refund($id) {
        
        if( !Auth::user()->hasPermissionTo('reseller-voucher-edit') )
            return response()->json('NOT Have Permission!', 422);
        
        $voucher = Voucher::find($id);
        
        if(!$voucher || $voucher->status != 'sold' )
            return response()->json('Voucher NOT Found or Status NOT "sold"!', 422);

        $input['status'] = 'refund';
        $voucher->update($input);
        
        return response()->json($voucher);        
        
    }
    
    private function vouchers_mas_refund($ids) {
        
        if(is_array($ids)){
            foreach($ids as $key=>$id){
                $voucher = Voucher::find($id);

                if(!$voucher || $voucher->status != 'sold')
                    unset ($ids[$key]);

                $input['status'] = 'refund';
                $voucher->update($input);

            }
            return $ids;        
        }else{
            return [];
        }        
    }
    
}
