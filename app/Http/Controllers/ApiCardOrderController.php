<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CardOrder;
class ApiCardOrderController extends Controller
{
    public function store(Request $request)
    {  
       
        $input = $request->all();
        
        CardOrder::create($input);
        return response()->json(['message'=>'تم تسجيل طلبك    ']);
    }
}
