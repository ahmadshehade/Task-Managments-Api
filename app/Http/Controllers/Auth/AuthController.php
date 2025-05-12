<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticationRequest;
use App\Interfaces\Authentication\AuthenticationInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authentication ;

    /**
     * Summary of __construct
     * @param \App\Interfaces\Authentication\AuthenticationInterface $authentication
     */
    public function __construct(AuthenticationInterface $authentication){

        $this->authentication = $authentication;
    }



    /**
     * Summary of register
     * @param \App\Http\Requests\Auth\AuthenticationRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function register(AuthenticationRequest $request){
        $data=$this->authentication->register($request);
       return $this->dataMessage($data,$data['code']);
    }


    /**
     * Summary of login
     * @param \App\Http\Requests\Auth\AuthenticationRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(AuthenticationRequest $request){
        $data=$this->authentication->login($request);
        return $this->dataMessage($data,$data['code']);
    }

    /**
     * Summary of logout
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public  function logout(Request $request){
        $data=$this->authentication->logout($request);
        return $this->dataMessage($data,$data['code']);
    }
}
