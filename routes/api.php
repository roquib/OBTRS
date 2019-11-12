<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->get('/category', function (Request $request) {
    return $request->user();
});


Route::apiResources(['user' => 'API\UserController']);
Route::get('profile', 'API\UserController@profile');

Route::apiResources(['group' => 'API\GroupController']);
Route::apiResources(['city' => 'API\CityController']);
Route::apiResources(['category' => 'API\CategoryController']);
Route::apiResources(['author' => 'API\AuthorController']);
Route::apiResources(['product' => 'API\ProductController']);
Route::apiResources(['detail' => 'API\DetailController']);
Route::get('/product/search/{search}', 'API\ProductController@search');
Route::get('/detail/search/{search}', 'API\DetailController@search');
Route::apiResources(['publication' => 'API\PublicationController']);
Route::apiResources(['supplier' => 'API\SupplierController']);
Route::apiResources(['counter' => 'API\CounterController']);
Route::apiResources(['trip-point' => 'API\TripPointController']);
Route::apiResources(['trip-route' => 'API\TripRouteController']);
Route::apiResources(['boarding' => 'API\BoardingController']);
Route::apiResources(['origincity' => 'API\OriginCityController']);
Route::apiResources(['destinationcity' => 'API\DestinationCityController']);
Route::apiResources(['route' => 'API\RouteController']);
Route::apiResources(['operator' => 'API\OperatorController']);
Route::apiResources(['purchase' => 'API\PurchaseController']);
Route::apiResources(['ticket' => 'API\SellTicketController']);


// public user

Route::get('currentUser', 'API\UserController@currentUser');
Route::get('category-list', 'API\CategoryController@category_list');
Route::get('author-list', 'API\AuthorController@author_list');
Route::get('ticket-list', 'API\SellTicketController@ticket_list');
Route::get('detail-list', 'API\DetailController@detail_list');
Route::get('counter-list', 'API\CounterController@counter_list');
Route::get('city-list', 'API\CityController@city_list');
Route::get('trip-point-list', 'API\TripPointController@trip_point_list');
Route::get('trip-route-list', 'API\TripRouteController@trip_route_list');
Route::get('last-trip-id', 'API\TripRouteController@last_trip_id');
Route::get('supplier-list', 'API\SupplierController@supplier_list');
Route::get('operator-list', 'API\OperatorController@operator_list');
Route::get('boarding-list', 'API\SupplierController@boarding_list');
Route::get('origincity-list', 'API\OriginCityController@origincity_list');
Route::get('destinationcity-list', 'API\DestinationCityController@destinationcity_list');
Route::get('route-list', 'API\RouteController@route_list');
Route::get('product-list', 'API\ProductController@product_list');

Route::post('/purchase/products/{supplier}', 'API\PurchaseController@storeProducts');
