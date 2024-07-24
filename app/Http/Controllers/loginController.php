<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Pegawai;
use App\Models\Custumer;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{ 
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        
        if (Auth::guard('custumer')->attempt($credentials)) {
            $user = Auth::guard('custumer')->user();
            $token = $user->createToken('Token',['custumer'])->plainTextToken;

            return response()->json(['data'=>$user, 'token' => $token, "type"=>"custumer"], 200);
        } else if(Auth::guard('pegawai')->attempt($credentials))
            {
                $user = Auth::guard('pegawai')->user();
                if($user->role_pegawai === 'ADMIN'){
                    $token = $user->createToken('Token',['ADMIN'])->plainTextToken;

                }else if($user->role_pegawai === 'SALES MARKETING' ){
                    $token = $user->createToken('Token',['SALES MARKETING'])->plainTextToken;

                }else if($user->role_pegawai === 'OWNER' ){
                    $token = $user->createToken('Token',['OWNER'])->plainTextToken;

                }else if($user->role_pegawai === 'GENERAL MANAGER' ){
                    $token = $user->createToken('Token',['GENERAL MANAGER'])->plainTextToken;

                }else if($user->role_pegawai === 'RESEPSIONIS' ){
                    $token = $user->createToken('Token',['RESEPSIONIS'])->plainTextToken;
                }

                return response()->json(['data'=>$user, 'token' => $token, "type"=>"pegawai"], 200);
            }
        else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }

    public function logout(Request $request){
    
        $user = $request->user();

        $user->tokens()->delete();

        return response()->json([
            'message' => 'You have successfully logged out',
            'user' => $user
        ], 200);
        
    }

    public function change_password(Request $request){
        $data = $request->only('password_lama','password','password_confirmation');
        $credentials = Validator::make($data, [
            'password_lama'=>['required'],
            'password' => ['required','confirmed'],
        ],[
            'password' => 'The password field is required',
            'password_lama' => 'The password field is required',
        ]);
        $user = $request->user();
        if(!Hash::check($request->password_lama, $user->password)){
            return response()->json([
                'status' => false,
                'message' => 'Old password does not match',
            ], 400);
        } 
        if($credentials->fails()) {
            return response(['success' => false,'message' => $credentials->errors()],400);  
        }
        $pegawai_exists = Pegawai::where('email',$user->email)->first();
        $custumer_exists = Custumer::where('email',$user->email)->first();
        
        
       if($pegawai_exists) {
            $pegawai_exists->password = \bcrypt($request->password);
            $pegawai_exists->update();
            return response([
                'message' => 'Succesfully update password PEGAWAI',
                'user' => $pegawai_exists,
            ],200);
        }else if($custumer_exists) {
            $custumer_exists->password = \bcrypt($request->password);
            $custumer_exists->update();
            return response([
                'message' => 'Succesfully update password CUSTUMER',
                'user' => $custumer_exists,
            ],200);
        }
        return response([
            'message' => 'user not found',
            'user' => null,
        ], 400);
    }

    
}
