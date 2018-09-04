<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use DB;
// using model below here
use App\User;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $user = DB::table('users')
                    ->select('name','email')
                    ->where('email','=',$request->get('email'))
                    ->get();
        $data = ([
            'author     '=>'R-nensia',
            'token type '=>'bearer',
            'account    '=>$user
            // 'expires_in :'=>$this->guard()->factory()->getTTL()*60
        ]);
        return response()->json(compact('data','token'));
    }

    public function register(Request $request)
    {
            $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        $generator = ([
            'author     :'=>'R-nensia',
            'token type :'=>'bearer',
        ]);

        return response()->json(compact('generator','user','token'),201);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                return response()->json(['token_absent'], $e->getStatusCode());
        }

        $generator = ([
            'author     '=>'R-nensia',
            'token type '=>'bearer',
        ]);

        return response()->json(compact('generator','user'));
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    public function guard()
    {
        return Auth::guard();
    }

    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

}
