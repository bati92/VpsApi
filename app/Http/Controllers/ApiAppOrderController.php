<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppOrder;
class ApiAppOrderController extends Controller
{
    public function store(Request $request)
    {  
        $input = $request->all();
        $order=AppOrder::create($input);
        $result=$this->operation($order);
        return response()->json(['message'=>'تم تسجيل طلبك    ']);
    }
    public function operation($order)
    {
        $user=auth::user();
        if($user )
         {
            if($user->balance>=$order->price)
             {
                $user->balance=$user->balance-$order->price;
                $user->save();
                $order->status="مقبول";
                $order->save();
                return "تمت عملية الشراء بنجاح";

             }
             $order->status="مرفوض";
             $order->save();
             return "فشل عملية الشراء:الرصيد غير كافي   ";
         }
    }
}
