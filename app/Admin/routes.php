<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
	'prefix' => config('admin.route.prefix'),
	'namespace' => config('admin.route.namespace'),
	'middleware' => config('admin.route.middleware'),
], function (Router $router) {

	$router->get('/', 'HomeController@index')->name('admin.home');

	$router->resource('categories', 'CategoryController');

	$router->resource('continents', ContinentController::class);

	$router->resource('countries', CountryController::class);

	$router->resource('worldcities', WorldCityController::class);

	$router->resource('attributes', AttributeController::class);

	$router->resource('attrvalues', AttrvalueController::class);
	
	$router->resource('destinations', DestinationController::class);

});
