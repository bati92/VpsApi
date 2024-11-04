<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
       $input = $request->all();
       $input['mobile'] = $input['code'] . $input['mobile'];
       $input['password'] = bcrypt($input['password']);

      $user=  User::create($input);
       Mail::to($input['email'])->send(new LoginEbank());
       return response()->json(['message'=>'تمت إضافة المستخدم بنجاح ']);
   
    }
    
    public function storeAgent(Request $request,$aget)
    {   //return   $aget;
      $id = explode('_', $aget)[1];

        $type = explode('_', $aget)[2];
       $user=User::where('id',$id)->first();

       $input = $request->all();
       if($type=='A')
              $input['role'] =2;
       else  if($type=='B')
              $input['role'] =3;
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
      
        return response()->json(['authenticated' => true], 200);
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
    {   $orders = collect();
        $user=User::findOrFail($id);
        $programs=$user->programs;
        $turkification=$user->turkificationOrders;
        $apps=$user->apps;
        $games=$user->games;
        $cards=$user->cards;
        $ecards=$user->ecards;
        $ebanks=$user->ebanks;
        $apps=$user->apps;

        $transfer=$user->transferOrders;
        $orders = $orders->merge($programs)
        ->merge($turkification)
        ->merge($apps)
        ->merge($games)
        ->merge($cards)
        ->merge($ecards)
        ->merge($ebanks)
        ->merge($transfer);
      
        return response()->json(["orders"=>$orders]);
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