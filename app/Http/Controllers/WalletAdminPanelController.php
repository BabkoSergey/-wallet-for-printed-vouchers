<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use App\Voucher;


class WalletAdminPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:admin_panel');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	$vaucher_count = Voucher::count();
	$vaucher_count_sold = Voucher::where('status','sold')->count();
	$vaucher_count_active = Voucher::where('status','activate')->count();
	$total_users = Voucher::whereNotNull('user_id')->distinct('user_id')->count('user_id');
        
        return view('WalletAdminPanel.dashboard', compact('vaucher_count','vaucher_count_sold','vaucher_count_active','total_users'));
    }


}