<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use App\Models\TransferMoneyFirmOrder;
use Illuminate\Support\Facades\DB;

class ApiTransferMoneyFirmOrderController extends Controller
{
    


    public function store(Request $request)
    {  
        $input = $request->all();
       
        TransferMoneyFirmOrder::create($input);
        
    return response()->json(['message' => 'تمت الإضافة بنجاح']);
        
    }
    public function myPayments($id)
    {
    
        // جلب الطلبات الخاصة بالمستخدم الحالي فقط
        $transferMoneyFirmOrders = DB::table('transfer_money_firm_orders')
            ->join('users', 'transfer_money_firm_orders.user_id', '=','users.id')
            ->join('transfer_money_firms', 'transfer_money_firm_orders.transfer_money_firm_id', '=', 'transfer_money_firms.id')
            ->where('transfer_money_firm_orders.user_id', '=', $id) // تصفية النتائج للمستخدم الحالي
            ->select('transfer_money_firm_orders.*', 'users.name as user_name', 'transfer_money_firms.name as transfer_money_firm_name')
            ->orderBy('transfer_money_firm_orders.id', 'desc')
            ->get();
    return response()->json(['orders' => $transferMoneyFirmOrders]);
    
       
    }


}
