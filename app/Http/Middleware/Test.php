<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Test
{

    public function handle($request)
    {

        $user = Auth::user();
        dd($user);
        if($user){
            dd("auth");
        }else {
            dd("not auth");
        }

    }



}
