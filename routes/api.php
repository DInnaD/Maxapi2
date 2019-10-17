<?php


use Symfony\Component\HttpFoundation\Response;

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

/***REGISTRATION***/
Route::post('register', 'Auth\RegisterController@register');
/***END-REGISTRATION***/

/***USER-LOGIN***/
Route::post('login', 'Auth\LoginController@login');
Route::post('auth', 'AuthController@socialLogin');
/***END-USER-LOGIN***/

/***END-USER-LOGOUT***/
Route::post('logout', 'Auth\LoginController@logout');
/***END-USER-LGOUT***/
	
//Route::group(['middleware' => ['jwt.auth']], function () {
Route::middleware('auth:api')->group(function () {

    /*** USER ***/
    Route::get('user/history', 'UserController@history');
    Route::get('user/profile', 'UserController@profile');
    Route::delete('user/history/{product}', 'UserController@deleteProduct');
    Route::delete('user/history/', 'UserController@deleteProductAll');

    Route::apiResource('user', 'UserController')->only([ 'index', 'show', 'update']);
    //Route::get('user', 'UserController@index');
    //Route::get('user/{user}', 'UserController@show');
    //Route::put('user', 'UserController@update');
	/*** END - USER ***/

	/*** PROFILE ***/


    Route::post('user/update/pass', 'UserController@updatePassword');

    Route::apiResource('profile', 'ProfileController')->except(['show', 'store']);
    // Route::get('profile', 'ProfileController@index');
    // Route::get('profile/update', 'ProfileController@update');
    // Route::get('profile/delete', 'ProfileController@destroy');
	/*** END - PROFILE ***/

	/*** CATEGORY ***/
    Route::apiResource('category', 'CategoryController');
	/*** END - CATEGORY ***/

    /*** PRODUCT ***/    
    Route::get('products/filter', 'ProductController@filter');//products/?filter

    Route::apiResource('product', 'ProductController');
    /*** END - PRODUCT ***/

	/*** COMMENT ***/
    Route::apiResource('comment', 'CommentController');
    /*** END - COMMENT ***/

    /*** AUTH ***/
	//Route::get('user/me', 'AuthController@me');
	//Route::get('user/delete', 'AuthController@refresh');
	/*** END - AUTH ***/
});




/***ADMIN-LOGIN***/
//Route::post('admin/login', 'AdminController@login');
/***END-ADMIN-LOGIN***/

//Route::get('user/verify/{token}', 'Auth\RegisterController@verifyUser');


    
