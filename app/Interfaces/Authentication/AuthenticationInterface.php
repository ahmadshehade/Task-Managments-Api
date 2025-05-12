<?php

namespace App\Interfaces\Authentication;

interface AuthenticationInterface{

    public function register($request);

    public function login($request);


    public function logout($request);
}
