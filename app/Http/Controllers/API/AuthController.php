<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
     public function store(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        // check if the user exists
        if (!is_null($user)) {
            return response()->json(['status' => false, 'message' => 'User already exists'], 400);
        }
        // validate the data 
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'min:2','max:100','string'],
            'last_name' => ['required', 'min:2','max:100','string'],
            'email' => ['required', 'email',Rule::unique('users','email')],
            'password' => ['required', 'min:7', 'max:100','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
            'phone' => [ 'min:8', 'max:15'],
        ]);
        // handle validation errors
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 400);
        }
        // assign data to a new user
        $user = new User();
        $user->fill($request->only(['first_name', 'last_name', 'email', 'password', 'phone']));
        $user->save();
        // create a token
        $token = $user->createToken('authToken')->plainTextToken;
        // return a response
        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'token' => $token
        ]);
    }
    public function login(Request $request){
        $user = User::where('email',$request->email)->first();
        if(! $user || !Hash::check($request->password,$user->password)){
            return response()->json([
                'status'=>false,
                'message'=>'These credentials do not match our records'
            ],400);
        }
        $access_token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'status' => true,
            'message' =>'User logged in successfully',
            'token'=>$access_token
        ]);
    }
}
