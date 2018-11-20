<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Voucher;

use App\Http\Controllers\VoucherController;

class MainController extends Controller
{
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

    /**
     * Show the application main page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                
        return view('main');
    }    
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function check_voucher(Request $request)
    {
        
        request()->validate([
            'voucher_key' => 'required',
            'voucher_date' => 'required',
        ]);
        
        $errors = $success = [];
                
        $voucher = Voucher::where('voucher',$request->get('voucher_key'))->first();
        
        if(!$voucher){
            $errors = ['Voucher with this KEY and Date Price not found!'];
        }else{
//            if(date('d/m/Y', strtotime($voucher->updated_at)) != $request->get('voucher_date')){
//                $errors = ['Voucher with this KEY and Date Price not found!'];
//            }else
            if($voucher->expire && strtotime($voucher->expire) < time()-24*60*60 && in_array($voucher->status,array('sale', 'sold'))){                
                $this->voucherController->hasExpire($voucher->id);
                $errors = ['Voucher overdue!'];
            }elseif($voucher->status != 'sold'){
                switch ($voucher->status){
                    case 'sale': $errors = ['The voucher does not have the status "Sold". Contact the seller!'];
                        break;
                    case 'activate': $errors = ['The voucher is already activated!'];
                        break;
                    default : $errors = ['The voucher is expired or blocked!'];
                        break;
                }                
            }else{
                $errors = ['success'=>['Expire Date: ' . ($voucher->expire ? $voucher->expire : 'Never') ]];
            }
                    
        }
                
        return redirect()->back()->withErrors($errors)->withInput($request->all());
    }    
    
}
