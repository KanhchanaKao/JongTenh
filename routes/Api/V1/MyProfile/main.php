<?php

	$api->group(['namespace' => 'App\Api\V1\Controllers\Profile'], function($api) {

        $api->get ('/',              		['uses' => 'ProfileController@get']);
		$api->put('/', 						['uses' => 'ProfileController@put']);
		$api->put('/change-password', 		['uses' => 'ProfileController@changePassword']); //Update
	});