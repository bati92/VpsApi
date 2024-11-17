<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

use App\Models\AppOrder;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;
  use App\Mail\LoginEbank;
use Illuminate\Support\Facades\Mail;
class ApiUserController extends Controller 
{   public function send($role)
    {    $user=Auth::user();
         if($role=="A")
          $agents=DB::table('users')->select('*')->where('agent_id', $user->id)->where('role', 2)->get();
        else
          $agents=DB::table('users')->select('*')->where('agent_id', $user->id)->whereIn('role', [3, 4])->get();
        return response()->json(['agents'=> $agents]);  

    }
    public function getAgents($role)
    {    $user=Auth::user();
         if($role=="A")
          $agents=DB::table('users')->select('*')->where('agent_id', $user->id)->where('role', 2)->get();
        else
          $agents=DB::table('users')->select('*')->where('agent_id', $user->id)->whereIn('role', [3, 4])->get();
        return response()->json(['agents'=> $agents]);  

    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'unique:users', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ], [
                'name.required' => 'الاسم مطلوب.',
                'name.string' => 'يجب أن يكون الاسم نصاً.',
                'name.unique' => 'الاسم مستخدم بالفعل، يرجى اختيار اسم آخر.',
                'name.max' => 'يجب ألا يزيد طول الاسم عن 255 حرفًا.',
                'email.required' => 'البريد الإلكتروني مطلوب.',
                'email.string' => 'يجب أن يكون البريد الإلكتروني نصًا.',
                'email.email' => 'يرجى إدخال عنوان بريد إلكتروني صالح.',
                'email.max' => 'يجب ألا يزيد طول البريد الإلكتروني عن 255 حرفًا.',
                'email.unique' => 'البريد الإلكتروني مستخدم بالفعل، يرجى اختيار بريد آخر.',
                'password.required' => 'كلمة المرور مطلوبة.',
                'password.string' => 'يجب أن تكون كلمة المرور نصية.',
                'password.min' => 'يجب ألا تقل كلمة المرور عن 8 أحرف.',
                'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            ]);
    
            // إنشاء المستخدم
            $input = $request->all();
            $input['mobile'] = $input['code'] . $input['mobile'];
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
    
            return response()->json(['message' => 'تمت إضافة المستخدم بنجاح']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->errors(),
            ], 422);
        }
    }
    
    
    public function storeAgent(Request $request,$aget)
    {   //return   $aget;
      $id = explode('_', $aget)[1];

        $type = explode('_', $aget)[2];
       $user=User::where('id',$id)->first();

       $input = $request->all();
       if($type=='A')
            { $input['role'] =2;
              $input['vip_id'] =1;
            }
       else  if($type=='B')
       {    $input['role'] =3;
            $input['vip_id'] =2;
      }
       else   $input['role'] =4;

       $input['mobile'] = $input['code'] . $input['mobile'];
       $input['password'] = bcrypt($input['password']);
       $input['agent_id'] =$id;
        User::create($input);
      
       return response()->json(['message'=>'تمت إضافة المستخدم بنجاح ']);
   
    }
    public function authCheck(Request $request)
    {  
      
       if (auth()->check()) {
      
        return response()->json(['authenticated' => true ,'auth'=>Auth::user()], 200);
       }
      return response()->json(['authenticated' => false], 200);
  
    }
    public function login(Request $request)
    {   //  return response()->json("hello");
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
    
      
        if (Auth::attempt($credentials)) {
           
            $user = Auth::user();
            $token = $user->createToken('auth_token')->accessToken;
            

            return response()->json(['token' => $token,'user'=>$user], 200);
        }
        else
        {
            return response()->json(['message'=>'المستخدم غير موجود'], 401);
        }
    }

    public function getLoggedInUser()
    {
        return response()->json(Auth::user());
    }

    
    public function myRequests($id)
    {
        $orders = collect();
        $user = User::findOrFail($id);
    
        $programs = $user->programs->map(function ($item) {
            $item->type = 'Program';
            return $item;
        });
    
        $turkification = $user->turkificationOrders->map(function ($item) {
            $item->type = 'Turkification';
            return $item;
        });
    
        $apps = $user->apps->map(function ($item) {
            $item->type = 'App';
            return $item;
        });
    
        $games = $user->games->map(function ($item) {
            $item->type = 'Game';
            return $item;
        });
    
        $cards = $user->cards->map(function ($item) {
            $item->type = 'Card';
            return $item;
        });
    
        $ecards = $user->ecards->map(function ($item) {
            $item->type = 'Ecard';
            return $item;
        });
    
        $ebanks = $user->ebanks->map(function ($item) {
            $item->type = 'Ebank';
            return $item;
        });
    
        $transfer = $user->transferOrders->map(function ($item) {
            $item->type = 'Transfer';
            return $item;
        });
    
        // دمج الطلبات
        $orders = $orders->merge($programs)
            ->merge($turkification)
            ->merge($apps)
            ->merge($games)
            ->merge($cards)
            ->merge($ecards)
            ->merge($ebanks)
            ->merge($transfer);
    
        // تحديث التاريخ بعد الدمج
        $orders = $orders->map(function ($item) {
            $item->created_at = \Carbon\Carbon::parse($item->created_at)->format('Y-m-d');
            return $item;
        });
    
        return response()->json(["orders" => $orders]);
    }
    
    
    
    public function update(Request $request,  $id)
    { 
        try {
            $user = User::findOrFail($id);
            $input = $request->all();
            if($request->file('image')!="")
            {
                if ($file = $request->file('image')) {
                    $name = 'user_'.time().$file->getClientOriginalName();
                    $file->move('images/users/', $name);
                    $input['image'] = $name;
                }
            }
            else
            {
                $input['image'] =$user['image'];
            }
            $input['password'] = bcrypt($input['password']);
            $user->update($input);
            return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
            ]);
        }
         catch(\Exception $e) 
        {
            return response()->json(['message'=>'حدث خطا أثناء محاولة تعديل المعلومات']);

        }
    }

}