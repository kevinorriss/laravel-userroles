<?php

Route::resource('role', 'KevinOrriss\UserRoles\Controllers\RoleController')->middleware(['web', 'auth']);
Route::resource('role_group', 'KevinOrriss\UserRoles\Controllers\RoleGroupController')->middleware(['web', 'auth']);