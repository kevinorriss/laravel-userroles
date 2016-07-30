<?php

Route::group(['middleware' => ['web', 'auth']], function () {
	Route::resource('roles', 'KevinOrriss\UserRoles\Controllers\RoleController');
	Route::resource('role_groups', 'KevinOrriss\UserRoles\Controllers\RoleGroupController');
	Route::resource('user_roles', 'KevinOrriss\UserRoles\Controllers\UserRoleController');
});
