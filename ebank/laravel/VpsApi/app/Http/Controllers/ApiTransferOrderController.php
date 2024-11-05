<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TransferOrder;
use Illuminate\Support\Facades\DB;
class ApiTransferOrderController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();
        TransferOrder::create($input);
        return response()->json(['message'=>'تم تسجيل طلبك    ']);
    }
}
 