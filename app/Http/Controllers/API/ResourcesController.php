<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Voucher;
use App\VoucherType;
use App\Http\Controllers\VoucherController;

class ResourcesController extends Controller {
    
    /**
     * VoucherController service instance.
     *
     * @var VoucherController
     */
    private $voucherController;
    
    public function __construct(VoucherController $voucherController)
    {
        $this->voucherController = $voucherController;        
    }
        
    public function activate(Request $request ) {
	
        $error = 'Access Denied';
        
        if(!$request->get('key') || !$request->get('user'))        
            return response()->json($error, 422);
        
        $voucher = Voucher::where('voucher',$request->get('key'))->first();
                
        if(!$voucher || $voucher->status != 'sold')
            return response()->json($error, 422);
        
        if($voucher->expire && strtotime($voucher->expire) < time()-24*60*60 ){
            if($voucher->status == 'sale' || $voucher->status == 'sold'){
                $this->voucherController->hasExpire($voucher->id);
            }            
            return response()->json($error, 422);
        }            
		
        $sold = $voucher->updated_at;
        
        $this->voucherController->hasActivate($voucher->id, $request->get('user'), $request->header('Operator-Name'));
                
        return response()->json([
                    'status'=>'Activate Success',
                    'amount'=>$voucher->price,
                    'date_sold'=>$sold,
                ]);

    }
    
    public function price_list(Request $request ) {
        
        $price_list = VoucherType::get();
        
        return response()->json($price_list);
    }
        
}
