<?php

Route::group(['middleware' => ['web', 'auth']], function () {
	Route::resource('roles', 'KevinOrriss\UserRoles\Controllers\RoleController');
	Route::resource('role_groups', 'KevinOrriss\UserRoles\Controllers\RoleGroupController');
	Route::get('user_roles/{user}', ['as' => 'user_roles.show', 'uses' => 'KevinOrriss\UserRoles\Controllers\UserRoleController@show']);
	Route::get('user_roles/{user}/edit', ['as' => 'user_roles.edit', 'uses' => 'KevinOrriss\UserRoles\Controllers\UserRoleController@edit']);
	Route::put('user_roles/{user}', ['as' => 'user_roles.update', 'uses' => 'KevinOrriss\UserRoles\Controllers\UserRoleController@update']);
});
