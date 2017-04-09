<?php

namespace App\Api\V1\Controllers;
use JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Api\BaseController;
use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Dingo\Api\Exception\StoreResourceFailedException;

class TestApiController extends BaseController
{
    public function index(){
        return User::all();
    }

    public function me(){
        return JWTAuth::parseToken()->authenticate();
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|between:6,10',
            'password_confirmation' => 'required'
        ];
        // validata
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // return the error msg
            throw new StoreResourceFailedException('Could not create new user.', $validator->errors());
        }
        $newUser = [
            'user_name' => $request->input('name'),
            'user_pass' => $request->input('password')
        ];
//        $user = User::create($newUser);
//        $user = User::first();
//        $token = JWTAuth::fromUser($user);

//        $customClaims = ['foo' => 'bar', 'baz' => 'bob'];
        $payload = JWTFactory::make($newUser);
        $token = JWTAuth::encode($payload)->get();

        $name = $newUser['user_name'];
        return response()->json(compact('token', 'name'));
    }

    public function login(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $where = [
            'email' => $credentials['email']
        ];
        $name = User::where($where)->value('user_name');
        // all good so return the token and name
        return response()->json(compact('token', 'name'));
    }

}
