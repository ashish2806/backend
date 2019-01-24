<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use App\User;
use Illuminate\support\Facades\Auth;
use Validator;
use DB;
class AdminController extends Controller
{
    //
   
    public $statusSuccess = 200;
    


    public function __construct(){
      //  $this->middleware('auth:api-admin');
    }
    public function adminlogin(){

       
        if(Auth::guard('api-web')->attempt(['email' => request('email'), 'password' => request('password')])){
     
            $user = Auth::guard('api-web')->user();
            $success['token'] = $user->createToken('Myappp')->accessToken;
            return response()->json(array('success' => $success,'status'=> $this->statusSuccess));
        } else{
          //  dd(DB::getQueryLog());
            return response()->json(array('error' => 'unauthorized','status'=>401));
        }
    }

    public function adminregister(Request $request){
        
        $validator  = Validator::make($request->all(),[
            'name' => 'required',
            'email' =>'required|email',
            'password' =>'required',
            'c_password' => 'required|same:password'

        ]);

        if($validator -> fails()){
            return response()->json(array('error' => $validator->errors()),401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user  =  Admin::create($input);
        $success['token'] = $user->createToken('Myappp')->accessToken;
        $success['name'] = $user->name;
        return response()->json(array('success' => $success),$this->statusSuccess);
    }


    public function admingetDetails(){
        $user = Auth::user();
       // dd($user);
        return response()->json(['success' => $user], $this->statusSuccess);
        exit;
    }


    
}
