<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Flash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Posts;

class UserController extends Controller
{
    function registerPage(){
        return view('client.userRegister');
    }
    function loginPage(){
        return view('client.userLogin');
    }
    function showHomePage(){
        $user = Auth::user()?->except('password');
        $allPost = Posts::where('deleted_at', null)->latest()->offset(0)->limit(100)->get();
        return view('welcome',['user' => $user ?? [], 'posts' => $allPost ?? []]);
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
    function LoginUser(Request $request){
        $validate = Validator::make($request->all(),[
            'email'    => 'required|exists:users,email',
            'password' => 'required|string'
        ]);

        if($validate->fails()){
            return response()->json([
                'success' => false,
                'message' => $validate->errors()->first(),
            ],200);
        }

       $isUserExist = User::where('email', $request->email)->first();
       if(!$isUserExist){
        return response()->json([
            'success' => false,
            'message' => 'User Not Found!'
        ],404);
       }

       if(Hash::check($request->password, $isUserExist->password)){
        Auth::login($isUserExist);
        $request->session()->flash('success', 'Logged in Sucessful!');
        return response()->json([
            'success' => true,
            'message' => 'User Loggedin!',
            'user'    => $isUserExist->makeHidden('password'),
        ],200);
       }else {
        return response()->json([
            'success' => false,
            'message' => 'Password Is Wrong!',
        ],401);
       }
       
    }
    function CreatePost(Request $request){
        if(!Auth::check()){
            return  response()->json([
                'message' => 'You need to Login!',
                'success' => false
            ],401);
        }
        

        // checking for post exist or not 
        $post_id = $request?->post_id;
        if($post_id){
            $imagePath = $request->file('image')?->store('image', 'public');
            $want_to_update = Posts::find($post_id);
            $want_to_update->deps = $request->deps ?? $want_to_update->deps;
            $want_to_update->image = $imagePath ?? $want_to_update->image;
            $status = $want_to_update->save();
            if($status){
                return response()->json([
                    'message' => 'Post Updated!',
                    'success' => true
                ],200);
            }else {
                return response()->json([
                    'message' => 'Something is wrong!',
                    'error'  => $status,
                ],500);
            }
        }
        $validate = Validator::make($request->all(),[
            'deps'  => 'required|string',
            'image' => 'required|mimes:png,jpeg,jpg,webp',
        ]);
        if($validate->fails()){
            return response()->json([
                'message' => $validate->errors()->first(),
                'status'  => false
            ]);
        }
        $imagePath = $request->file('image')->store('image', 'public');
        if(!$imagePath){
            return response()->json([
                'message' => "Image could'nt upload",
                'success' => false
            ]);
        }
        $user_Id = Auth::user()?->id;
        $post = Posts::create([
            'deps'  => $request->deps,
            'image' => $imagePath,
            'user_id' => $user_Id
        ]);
        $post->user_id = $user_Id;
        $post->save();

        if(!$post){
            return response()->json([
                'message' => "Post Failed!",
                'success' => false,
                'user_id' => $user_Id
            ]);
        }
        return response()->json([
            'post' => $post,
            'message' => "Post created!",
            'success' => true
        ]);
    }
    function showExistingPostData(Request $request){
        $id = $request->get('post_id');
        $status = Posts::find($id);
        if($status){
            return response()->json([
                'status' => true,
                'post' => $status,
            ]);
        }
    }
    function deletePost(Request $request){
        $id = $request->get('post_id');
        if(!$id){
            return response()->json([
                'message' => 'Post id is Required!',
                'success' => false
            ],401);
        }
        $post = Posts::find($id);
        if(!$post){
            return response()->json([
                'message' => 'Post Not Found',
                'status' => false
            ]);
        }

          $post->deleted_at = Carbon::now();
         $status = $post->save();
        if($status){
            return response()->json([
                'message' => 'Post Deleted Successfully',
                'success' =>true
            ],200);
        }else {
            return response()->json([
                'message' => 'Failed to delete post!',
                'error'  => $status->error,
            ],500);
        }

    }
}
