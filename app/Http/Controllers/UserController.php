<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    function index(){
        return view('client.userRegister');
    }

    function RegisterUser(Request $request){
        
        $validate = Validator::make($request->all(), [
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users,email,',
            'number'   => 'required|min:10',
            'password' => 'required|min:4'
        ]);

        if($validate->fails()){
           return response()->json([
                'success' => false,
                'message' =>$validate->errors()->first(),
            ]);
        }

        $data = $validate->validated();
        $data['password'] = Hash::make($data['password']);
        $status = User::create($data);
        if($status){
            return response()->json([
                'success' => true,
                'message' => 'User Registered!'
            ]);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Failded To Reister User!',
            ]);
        }

    }
    
}
