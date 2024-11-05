<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EbankOrder;
class ApiEBankOrderController extends Controller
{
    public function store(Request $request)
    {  
       
        $input = $request->all();
       
   //return $input;
        EbankOrder::create($input);
        return response()->json(['message'=>'تم تسجيل طلبك    ']);
    }
}
