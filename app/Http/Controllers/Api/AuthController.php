<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Validation\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized', 'result'=>false, 'access_token'=>''], 401);
        }

        return response()->json([
            'result'=>true,
            'message'=>'Successful',
            'access_token' => $token
        ]);
    }

    public function register(Request $request)
    {

        $rule = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if($rule->fails())
            return response()->json(['result'=>false,'access_token'=>'', 'message'=>'Your email exist already.']);

        $data = $request->all();
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->surname = $data['surname'];
        $user->password = Hash::make($data['password']);
        $user->save();

        $credentials = $request->only(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized', 'result'=>false, 'access_token'=>''], 401);
        }

        return response()->json([
            'result' => true,
            'access_token' => $token,
            'message' => 'Successful'
        ]);
    }

     /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        if(Auth::check()){
            Auth::logout();
        }
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
