<?php

use App\Http\Resources\CountryResource;
use App\Http\Resources\WorldcityResource;
use App\Model\Country;
use App\Model\Worldcity;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

Route::get('worldcities/getabroadcities', 'WorldcityController@getabroadcities')->name('getabroadcities');

Route::get('worldcities/getabroadcitiesbycountry', 'WorldcityController@getabroadcitiesbycountry')->name('getabroadcitiesbycountry');


Route::get('worldcities/getchinacitiesbykeyword', 'WorldcityController@getchinacitiesbykeyword')->name('getchinacitiesbykeyword');

// // 准备删除
// Route::get('worldcities/getareasgroupby', 'WorldcityController@getareasgroupby')->name('getareasgroupby');


Route::get('worldcities/all', 'WorldcityController@allcities')->name('allcities');

// 准备删除
Route::get('worldcities', function () {
	return WorldcityResource::collection(Worldcity::all());
});

// 准备删除
Route::get('countries', function () {
	return CountryResource::collection(Country::paginate(5));
});


// --resource
// 准备删除
Route::get('countries/getcitesbycountryresource','CountryController@getcitesbycountryresource')->name('getcitesbycountryresource');

// CountryController
Route::get('countries/getcountries','CountryController@getcountries')->name('getcountries');

// 准备删除
Route::get('countries/getcountrycities','CountryController@getcountrycities')->name('getcountrycities');



Route::get('countries/getcountrywithcities','CountryController@getcountrywithcities')->name('getcountrywithcities');
