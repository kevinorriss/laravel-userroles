<?php

Route::resource('role', ['uses' => 'KevinOrriss\UserRoles\Controllers\RoleController', 'middleware' => ['web', 'auth']]);
Route::resource('role_group', ['uses' => 'KevinOrriss\UserRoles\Controllers\RoleGroupController', 'middleware' => ['web', 'auth']]);