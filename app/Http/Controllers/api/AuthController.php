<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\helperTrait\apiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\Translation\t;

class AuthController extends Controller
{


    use apiResponse;

    public function __construct()
    {
        $this->middleware('auth:api',['except'=>['login','register']]);  //all secret but login is public
    }


    //register
    public function register(Request $request)
    {

        $validator = validator::make($request->all(),[

                 'name'=>'required|max:20|string',
                 'email'=>'required|email|unique:users,email',
                 'password'=>'required|min:6'

        ]);


        if($validator->fails()){

            return $this->TheResponse('null',400,$validator->errors()->toJson());

        }else{

            $user = User::create(array_merge($validator->validated(),['password'=>bcrypt($request->password)]));  // to encrypt pass and creat merge to array pass AND data through valedation


           return $this->TheResponse($user,200,'register success');
        }
    }

    //login
    public function login(Request $request)
    {

        $validator = validator::make($request->all(),[

            'email'=>'required|email',
            'password'=>'required'

        ]);


        if($validator->fails()){

            return $this->TheResponse(null,400,$validator->errors()->toJson());
        }


        //the token not equal the data through in validation
        if( !$token = auth()->guard('api')->attempt($validator->validated()))
        {
            return $this->TheResponse(null,400,'Unauthorized');
        }


        return  $this->createNewToken($token);  // if true information equall data in token create token
    }

    //profile
    public function profile(){

        $data = auth()->guard('api')->user();
        return $this->TheResponse($data,'200','success');

    }

    //refresh token
    public function refresh(){

        return $this->createNewToken(auth()->guard('api')->refresh());
    }

    //logout
    public function logout(){

       auth('api')->logout();

        return $this->TheResponse(null,200,'success logout');

    }

    // create token type brearer
    protected function createNewToken($token){

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60,
            'user' => auth()->guard('api')->user()
        ]);
    }


}
