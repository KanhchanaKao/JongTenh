<?php

	$api->group(['namespace' => 'App\Api\V1\Controllers\Customer'], function($api) {

		//====================================================================================>Order
		$api->delete('/orders/{id}', 					['uses' => 'OrderController@delete']);
		$api->post('/makeorder', 						['uses' => 'OrderController@create']);
		//====================================================================================>History
		$api->get('/order/history',						['uses' => 'OrderController@orderHistory']);
		//====================================================================================>Categories
		$api->get ('/categories',              			['uses' => 'CategoryController@listing']);
		
		

	});