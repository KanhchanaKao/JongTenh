<?php

	$api->group(['namespace' => 'App\Api\V1\Controllers\CP'], function($api) {

		$api->get('/orders', 			        		['uses' => 'OrderController@listing']);
		$api->post('/orders/accept/{id}',				['uses' => 'OrderController@acceptOrder']);
		$api->post('/orders/reject/{id}',				['uses' => 'OrderController@rejectOrder']);
		$api->delete('/orders/{id}', 					['uses' => 'OrderController@delete']);

		$api->get('/customers',							['uses' => 'CustomerController@listing']);
		$api->post('/customers/{id}/change-password',   ['uses' => 'CustomerController@changePassword']);
		$api->post('/order', 							['uses' => 'OrderController@create']);
		$api->get('/sales', 							['uses' => 'OrderController@listing']);
		$api->delete('/sales/{id}', 					['uses' => 'OrderController@delete']);
		$api->get('/order/status',						['uses' => 'OrderController@getStatus']);
	//==============================================================================================>Category
		$api->get ('/categories',              			['uses' => 'CategoryController@listing']);
		$api->post('/categories',              			['uses' => 'CategoryController@create']);
		$api->post('/subcategories',              		['uses' => 'CategoryController@createsubcategory']);
		$api->put('/categories/{id}',         			['uses' => 'CategoryController@update']);
		$api->delete('/categories/{id}',       			['uses' => 'CategoryController@delete']);
	//==============================================================================================> Recommendation
		$api->get ('/recommendation/rates',             ['uses' => 'RecommendationController@rate']);
		$api->get ('/recommendation/top-review',        ['uses' => 'RecommendationController@review']);
		$api->get ('/recommendation/top-sale',          ['uses' => 'RecommendationController@sale']);

	//==============================================================================================>Product
		$api->get ('/products',              			['uses' => 'ProductController@listing']);
		$api->get ('/products/{id}',              		['uses' => 'ProductController@view']);
		$api->get ('/stock/products',              		['uses' => 'ProductController@listing']);
		$api->get ('/get/categories',                   ['uses' => 'ProductController@getCategory']);
		$api->get ('/get/supplier',                     ['uses' => 'ProductController@getSupplier']);
		$api->post('/products',              			['uses' => 'ProductController@create']);
		$api->put ('/products/{id}',         			['uses' => 'ProductController@update']);
		$api->delete('/products/{id}',       			['uses' => 'ProductController@delete']);
	//==============================================================================================>Supplier
		$api->get ('/supplier',              			['uses' => 'SupplierController@listing']);
		$api->post('/supplier',              			['uses' => 'SupplierController@create']);
		$api->put('/supplier/{id}',         			['uses' => 'SupplierController@update']);
		$api->delete('/supplier/{id}',       			['uses' => 'SupplierController@delete']);
	//==============================================================================================>Stock
		$api->get('/purchase/supplier',					['uses' => 'PurchaseController@getSupplier']);
		$api->post('/purchase/product',                 ['uses' => 'PurchaseController@create']);
		$api->post('/stock/stock-request',				['uses' => 'StockInController@stockRequest']);
		$api->get('/stock',								['uses' => 'StockInController@listing']);
		$api->post('/stock/stock-in/{id}',				['uses' => 'StockInController@makeStock']);
	});