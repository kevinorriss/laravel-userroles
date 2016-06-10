<?php

return [
	
	/*
    |--------------------------------------------------------------------------
    | Default table name where users are stored
    |--------------------------------------------------------------------------
    |
    | Here you may specify the name of the user table in your database. If left
    | then the default 'users' table will be used.
    |
    */
	'user_table' => env('USER_TABLE', 'users'),

	/*
    |--------------------------------------------------------------------------
    | Default column name in the user_table that uniquely identifies a user
    |--------------------------------------------------------------------------
    |
    | Here you may specify the name of the column in the user_table which
    | uniquely identifies a user. If left then the default 'id' column will
    | be used.
    |
    */
	'user_column' => env('user_column', 'id')

];