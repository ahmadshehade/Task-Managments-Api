<?php

namespace App\Services\Authentication;

use App\Interfaces\Authentication\AuthenticationInterface;
use App\Models\User;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;

class AuthenticationService implements AuthenticationInterface{



/**
 * Summary of register
 * @param mixed $request
 * @throws \Illuminate\Http\Exceptions\HttpResponseException
 * @return array{code: int, message: string, status: bool, token: string, user: User|array{code: int, message: string, status: bool}}
 */
public function register($request)
{
    try {
        $user = User::create($request->validated());

        if ($user) {
            $token = $user->createToken('user_auth')->plainTextToken;

            return [
                'message' => 'Successfully Created User',
                'token' => $token,
                'user' => $user,
                'status' => true,
                'code' => 201
            ];
        }

        return [
            'message' => 'Failed to Create User',
            'status' => false,
            'code' => 400
        ];

    } catch (\Exception $e) {
        throw new HttpResponseException(response()->json([
            'message' => 'Error: ' . $e->getMessage(),
            'status' => false,
            'code' => 500
        ], 500));
    }
}


    /**
     * Summary of login
     * @param mixed $request
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, message: string, status: bool, token: string, user: User}
     */
    public function login($request){
        try {
            $user=User::where('email',$request->validated()['email'])->first();
            if(!$user){
                throw new HttpResponseException(response()->json([
                    'message'=> 'User Not Found Please Register',
                    'status'=> false,

                ],404));
            }
            if($user && Hash::check($request->validated()['password'],$user->password)){
                 $token=$user->createToken('user_auth')->plainTextToken;
                    $data= [
                        'message' => 'Successfully Login',
                        'token' => $token,
                        'user' => $user,
                        'status' => true,
                        'code' => 201
                    ];
                    return $data;
            }
            $data=[
                'message'=>'try Again !',
                'code'=>404,
            ];
            return $data;
        }
        catch (\Exception $e) {
            throw new HttpResponseException(response()->json([
                'message' => 'Error: ' . $e->getMessage(),
                'status' => false,
                'code' => 500
            ], 500));
        }
    }


    /**
     * Summary of logout
     * @param mixed $request
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, message: string, status: bool}
     */
    public function logout($request){
        $user=$request->user();

        if(!$user){
            throw new HttpResponseException(response()->json([
                'message' => 'User Not Found Please Login',
                'status' => false,
            ],404));
        }
         $user->tokens()->delete();
        $data= [
            'message' => 'Successfully Logout',
            'status' => true,
            'code' => 200
        ];
        return $data;
    }
  }


