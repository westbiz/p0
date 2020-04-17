<?php

use App\Http\Resources\CountryResource;
use App\Http\Resources\WorldcityResource;
use App\Http\Resources\CountryCollection;
use App\Http\Resources\ContinentResource;
use App\Model\Country;
use App\Model\Continent;
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

Route::get('worldcities/getcitieswithdesinationwords', 'WorldcityController@getcitieswithdesinationwords')->name('getcitieswithdesinationwords');

Route::get('worldcities/getabroadcitiesbycountry', 'WorldcityController@getabroadcitiesbycountry')->name('getabroadcitiesbycountry');

Route::get('worldcities/getchinacitiesbykeyword', 'WorldcityController@getchinacitiesbykeyword')->name('getchinacitiesbykeyword');

Route::get('worldcities/all', 'WorldcityController@allcities')->name('allcities');



// ***API路由***
// 获取所有城市
Route::get('worldcities', 'API\WorldcityController@index')->name('worldcities.index');
// 获取单个
Route::get('worldcities/{id}', 'API\WorldcityController@show')->name('worldcities.show');


// countries--resource
// 准备删除
Route::get('countries/getcitesbycountryresource', 'CountryController@getcitesbycountryresource')->name('getcitesbycountryresource');

// CountryController
Route::get('countries/getcountries', 'CountryController@getcountries')->name('getcountries');

// 准备删除
Route::get('countries/getcountrycities', 'CountryController@getcountrycities')->name('getcountrycities');

Route::get('countries/getcountrywithcities', 'CountryController@getcountrywithcities')->name('getcountrywithcities');


// --chinaareas
Route::get('chinaareas/getcitiesbyprovince', 'ChinaAreaController@getcitiesbyprovince')->name('getcitiesbyprovince');


// // ***API路由***
// 通过request->get('q')
// 准备删除
Route::get('countries/getCountriesByContinent', 'API\CountryController@getCountriesByContinent')->name('getCountriesByContinent');

// 准备删除
Route::get('countries/getAreasByContinent/{id}', function($id) {
	// 获取所有
    return  new CountryCollection(Country::where('continent_id','=',$id)->paginate(10));
})->name('getCountriesByContinent');


// 搜索名称关键字--返回单个资源
// 准备删除
Route::get('countries/getCountryByName','API\CountryController@getCountryByName');

// 返回单个资源
Route::get('countries/{id}', 'API\CountryController@show')->name('countries.show');


// 返回资源集合
Route::get('countries', 'API\CountryController@index')->name('countries.index');

// ***Continent****
// 返回单个资源
Route::get('continents','API\ContinentController@index')->name('continents.index');

Route::get('continents/{id}', 'API\ContinentController@show')->name('continents.show');

// 准备删除
// Route::get('continents/{id}/countries','API\ContinentController@getCountries')->name('continents.countries');
