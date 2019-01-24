<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\support\Facades\Auth;
use Validator;
class UserController extends Controller
{
    //
    public $statusSuccess = 200;

    public function login(){
        if (Auth::attempt(array('email' => request('email'), 'password' => request('password')))){
            $user = Auth::user();
            $success['token'] = $user->createToken('Myappp')->accessToken;
            return response()->json(array('success' => $success,'status'=> $this->statusSuccess));
        } else{
            return response()->json(array('error' => 'unauthorized','status'=>401));
        }
    }

    public function register(Request $request){
        
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
        $user  =  User::create($input);
        $success['token'] = $user->createToken('Myappp')->accessToken;
        $success['name'] = $user->name;
        return response()->json(array('success' => $success),$this->statusSuccess);
    }


    public function getDetails(){
        $user = Auth::user();

        return response()->json(['success' => $user], $this->statusSuccess);
    }


    
}
