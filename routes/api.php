<?php

use Illuminate\Http\Request;

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

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    //================================================================================>Athentication
	$api->group(['prefix' => 'auth', 'middleware' => 'cors'], function ($api) {
        require(__DIR__.'/Api/V1/Auth/main.php');
    });
    //================================================================================>Admin
    $api->group(['middleware' => 'api.auth'], function($api) {
        $api->group(['prefix' => 'cp', 'middleware' => 'cors'], function ($api) {
            require(__DIR__.'/Api/V1/CP/main.php');
        });
    });
    //================================================================================>Customer Route
    $api->group(['middleware' => 'api.auth'], function($api) {
        $api->group(['prefix' => 'customer', 'middleware' => 'cors'], function ($api) {
            require(__DIR__.'/Api/V1/Customer/product.php');
        });
    });

    //================================================================================>My Profile
    $api->group(['middleware' => 'api.auth'], function($api) {
        $api->group(['prefix' => 'my-profile', 'middleware' => 'cors'], function ($api) {
            require(__DIR__.'/Api/V1/MyProfile/main.php');
        });
    });

    $api->group(['prefix' => 'public', 'middleware' => 'cors'], function ($api) {
        require(__DIR__.'/Api/V1/Customer/home.php');
    });

});
