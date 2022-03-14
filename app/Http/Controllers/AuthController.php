<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Validator;
use Illuminate\support\Facades\Hash;

use App\Models\User;
class  AuthController extends Controller
{
    public function login(Request $request){
        $user = User::where('email', $request->email)-> first();
//        return $user;
        if(!$user || !Hash::check($request->password, $user->password, [])){ // user not exist or incorrect password
            return response()->json(
                [
                    'message' => 'User not exist!',
                ],
                404
            );
        }
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json(
            [
                'access_token' => $token,
                'type_token' => 'Bearer',
                'message' =>'Login successfully'
            ],
            200
        );

    }
    public function register(Request $request)
    {
        $messages =[
            'email.email'=>"Error email",
            'email.required'=>"Please enter your email!",
            'password.required => "Please fill in the password field',
        ];
        $validate = Validator::make($request->all(),[
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email'=>['required', 'string', 'email', 'max:255','unique:users'], //
            'password' => ['required', 'string', 'min:8'],
        ], $messages);

        if($validate->fails()){
            return response()->json(
                [
                    'message' => $validate->errors(),
                ],
                404
            );
        }
        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request-> last_name,
            'email'=> $request->email,
            'password' =>  bcrypt($request->password),
        ]);
        return response()->json(
            [
                'message' => "Created account",
            ],
            201
        );
    }
    public function user(Request $request){
        return $request->user();
    }

    public function logout(){
        // Revoke all tokens...
        auth()->user()->tokens()->delete();

        // Revoke the token that was used to authenticate the current request...
//        $request->user()->currentAccessToken()->delete();

        // Revoke a specific token...
//        $user->tokens()->where('id', $tokenId)->delete();

        return response()->json(
            [
                'message' => "Logged out!",
            ],
            200
        );
    }
}
