<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

class checkKeyToThrough
{


    public function handle(Request $request, Closure $next)
    {


        if($request->through_pass != env('API_THROUGH_PASS','AwedQY2/cQ1wKq20MU')){

            return response()->json(['message'=>'un allowed should send through pass']);

        }

        return $next($request);
    }
}
