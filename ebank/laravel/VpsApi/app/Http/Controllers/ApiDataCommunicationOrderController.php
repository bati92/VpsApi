<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataCommunicationOrder;
class ApiDataCommunicationOrderController extends Controller
{
    public function store(Request $request)
    {  
       
        $input = $request->all();
     
        DataCommunicationOrder::create($input);
        return response()->json(['message'=>'تم تسجيل طلبك    ']);
    }
}
