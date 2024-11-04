<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramOrder;
class ApiProgramOrderController extends Controller
{
    public function store(Request $request)
    {  
       
        $input = $request->all();
        
       // return $input;
        ProgramOrder::create($input);
        return response()->json(['message'=>'تم تسجيل طلبك    ']);
    }
}
