<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\App;
use Illuminate\Support\Facades\DB;


class ApiAppController extends Controller
{
    public function index()
    {
       $apps=DB::table('apps')->select('*')->orderBy('id', 'desc')->paginate(500);
       foreach ($apps as $app) {
         $app->image_url = asset('assets/images/apps/' . $trans->image);  // إنشاء رابط للصورة
     }
       return response()->json(['apps'=>$apps ]);
    }
    public function show($id)
    {
       $app = App::findOrFail($id);
       return response()->json(['app'=>$app ]);
    }
}
