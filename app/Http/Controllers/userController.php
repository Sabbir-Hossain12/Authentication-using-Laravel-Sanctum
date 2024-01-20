<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class userController extends Controller
{
    function registration(Request $request)
    {



        try {
            User::create(
                [
                    'firstName'=> $request->input('firstName'),
                    'lastName'=> $request->input('lastName'),
                    'email'=> $request->input('email'),
                    'mobile'=> $request->input('mobile'),
                    'password'=>Hash::make($request->input('password'))

                ] );

            return response()->json(['status'=>'success','message'=>'Registration Successful']);
        }
        catch (Exception $exception)
        {
            return response()->json(['status'=>'failed','message'=>$exception->getMessage()]);
        }


    }

   function login(Request $request)
   {
       try {
            $email= $request->input('email');
            $password= $request->input('password');

          $user=  User::where('email',$email)->first();


          if($user && Hash::check($password,$user->password))
          {
              $token = $user->createToken('authToken')->plainTextToken;

              return response()->json(['status'=>'success','message'=>'Login Successful','token'=>$token])
                  ->cookie('token',"Bearer $token",time()+60*60);
          }
          else
          {
              return response()->json(['status'=>'failed','message'=>'Invalid User']);
          }

       }
       catch (Exception $exception)
      {
          return response()->json(['status'=>'failed','message'=>$exception->getMessage()]);
      }
   }


   function userProfile()
   {
        return Auth::user();
//        return Auth::id();
//        return Auth::user()['email'];
   }



   function updateProfile(Request $request)
   {
       try {
           $id= Auth::id();

           User::where('id',$id)->update(
               [
                   'firstName'=>$request->input('firstName'),
                   'lastName'=>$request->input('lastName'),
                   'mobile'=>$request->input('mobile'),
                   'password'=> Hash::make($request->  input('password'))
               ]
           );
           return response()->json(['status'=>'success','message'=>'user Updated Successfully']);
       }
       catch (Exception $exception)
       {
           return response()->json(['status'=>'failed','message'=>$exception->getMessage()]);
       }

   }

   function logout(Request $request)
   {
       $request->user()->tokens()->delete();

       return "logout done";
   }
}
