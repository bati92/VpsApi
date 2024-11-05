<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppOrder;
class ApiAppOrderController extends Controller
{
    public function store(Request $request)
    {   //return response()->json(['message'=>'تم تسجيل طلبك    ']);
       
        $input = $request->all();
    
   
        AppOrder::create($input);
        return response()->json(['message'=>'تم تسجيل طلبك    ']);
    }
}
