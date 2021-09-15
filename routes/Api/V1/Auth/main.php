<?php

	$api->group(['namespace' => 'App\Api\V1\Controllers\Auth'], function($api) {
		$api->post('/login',                            ['uses' => 'LoginController@login']);
		$api->post('/register', 			        	['uses' => 'RegisterController@register']);
		$api->post('/change-password', 			        ['uses' => 'ForgotPasswordController@changePassword']);
	});