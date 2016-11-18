<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
if (isset($_SERVER['HTTP_ORIGIN'])) {
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, PATCH');
	header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, useXDomain, withCredentials');
}
// Route::get('/', function () {
    // return Response::json(array('hello' => 'hehe'));
// });

//Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
Route::group(['middleware' => 'cors'], function()
{	
	// Session //
	Route::get('session','AuthenticateController@index');
	Route::post('session', 'AuthenticateController@authenticate');
	Route::delete('session', 'AuthenticateController@destroy');
	
	// Branch //
	Route::get('dqs_branch', 'BranchController@index');
	Route::patch('dqs_branch/{brcd}', 'BranchController@update');
	Route::get('dqs_branch/export', 'BranchController@export');
	
	// Branch Operation //
	Route::resource('dqs_branch_operation', 'BranchOperationController');
	
	// File Management //
	Route::get('dqs_file', 'FileControlller@index');
	Route::patch('dqs_file/{file_id}', 'FileController@update');

	// Role //
	Route::get('dqs_role/{role_id}/authorize', 'RoleController@roleauth');
	Route::post('dqs_role/{role_id}/authorize', 'RoleController@authorization');
	Route::resource('dqs_role', 'RoleController');
	
	// Menu //
	Route::get('dqs_menu/{menu_id}/authorize', 'MenuController@menuauth');
	Route::post('dqs_menu/{menu_id}/authorize', 'MenuController@authorization');
	Route::resource('dqs_menu', 'MenuController');	
	
	// System Configuration //
	Route::get('dqs_system_config', 'SystemConfigController@index');
	Route::post('dqs_system_config/kpi_date', 'SystemConfigController@kpi_date');
	Route::post('dqs_system_config/export_file', 'SystemConfigController@export_file');
	Route::post('dqs_system_config/import_file', 'SystemConfigController@import_file');
	Route::post('dqs_system_config/warning_branch', 'SystemConfigController@warning_branch');
	Route::post('dqs_system_config/grade_date', 'SystemConfigController@grade_date');
	
	// User //
	Route::get('dqs_user/cost_center', 'UserController@auto_cost_center');
	Route::get('dqs_user/revised_cost_center', 'UserController@list_revised_cost_center');
	Route::get('dqs_user/personnel_id', 'UserController@auto_personnel');
	Route::get('dqs_user', 'UserController@index');

	Route::get('404', ['as' => 'notfound', function () {
		return response()->json(['status' => '404']);
	}]);

	Route::get('405', ['as' => 'notallow', function () {
		return response()->json(['status' => '405']);
	}]);	
});


