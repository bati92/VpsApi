<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameOrder;
class ApiGameOrderController extends Controller
{
    public function store(Request $request)
    {  
       
        $input = $request->all();
       
   
        GameOrder::create($input
    );
        return response()->json(['message'=>'تم تسجيل طلبك    ']);
    }
}
