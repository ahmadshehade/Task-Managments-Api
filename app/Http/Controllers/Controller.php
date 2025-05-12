<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function dataMessage($data,$code){

        return response()
       ->json($data,$code);
    }
}
