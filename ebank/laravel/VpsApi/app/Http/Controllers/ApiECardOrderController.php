<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EcardOrder;
class ApiECardOrderController extends Controller
{  public function store(Request $request)
    {  
       
        $input = $request->all();
     
   
        EcardOrder::create($input);
        return response()->json(['message'=>'تم تسجيل طلبك    ']);
    }
}
