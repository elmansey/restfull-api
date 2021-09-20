<?php


namespace App\Http\helperTrait;


trait apiResponse{

    public function TheResponse($data ,$status,$message)
    {

        return response()->json([

            'status'=>$status,
            'message'=>$message,
            'data'=>$data

        ]);

    }



}
