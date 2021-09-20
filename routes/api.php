<?php


use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\postController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// public not secrit in midlewre auth and check to through


// create and login
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);


//get all posts can show without login public
Route::get('/posts',[postController::class,'index']);


Route::group(['middleware'=>['checkKeyToThrough','auth:api']],function (){

    //auth
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('/profile',[AuthController::class,'profile']);
    Route::post('/refresh',[AuthController::class,'refresh']);



    // show post by id
    Route::post('/post',[postController::class,'show']);

    //add post
    Route::post('/addPost',[postController::class,'store']);

    //update post
    Route::post('/update',[postController::class,'update']);

    //delete post
    Route::post('/delete',[postController::class,'delete']);
});
