<?php

Route::group(['middleware' => ['web', 'auth']], function () {
	Route::resource('roles', 'KevinOrriss\UserRoles\Controllers\RoleController');
	Route::resource('role_groups', 'KevinOrriss\UserRoles\Controllers\RoleGroupController');
});
