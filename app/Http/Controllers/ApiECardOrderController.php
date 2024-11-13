<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EcardOrder;
use Illuminate\Support\Facades\Auth;
class ApiECardOrderController extends Controller
{  public function store(Request $request)
    {  
       
        $input = $request->all();
     
   
        $order=EcardOrder::create($input);
        $result=$this->operation($order);
        return response()->json(['message'=>$result]);
    }
    public function operation($order)
    {
        $user=Auth::user();
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
         return "فشل عملية الشراء:الرصيد غير كافي   ";
    }
}
