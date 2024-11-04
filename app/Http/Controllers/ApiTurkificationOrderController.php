<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TurkificationOrder;
class ApiTurkificationOrderController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();

        TurkificationOrder::create($input);
        return response()->json(['message'=>'تم تسجيل طلبك    ']);
    }
}
