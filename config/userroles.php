<?php

return [
	
	/*
    |------------------------------------------------------------------------------
    | Default table name where users are stored
    |------------------------------------------------------------------------------
    |
    | Here you may specify the name of the user table in your database. If left
    | then the default 'users' table will be used.
    |
    */
	'user_table' => env('USER_ROLES_USER_TABLE', 'users'),

	/*
    |------------------------------------------------------------------------------
    | Default column name in the user_table that uniquely identifies a user
    |------------------------------------------------------------------------------
    |
    | Here you may specify the name of the column in the user_table which uniquely 
    | identifies a user by a text value. This could be something like a username or
    | email address. This value will be used in the UI. If left then the default
    | 'username' column will be used.
    |
    */
	'user_id_column' => env('USER_ROLES_USER_ID_COLUMN', 'id'),

    /*
    |------------------------------------------------------------------------------
    | Default column name in the user_table that uniquely identifies a user by name
    |------------------------------------------------------------------------------
    |
    | Here you may specify the name of the column in the user_table which
    | uniquely identifies a user. If left then the default 'id' column will
    | be used.
    |
    */
    'user_name_column' => env('USER_ROLES_USER_NAME_COLUMN', 'username'),

    /*
    |------------------------------------------------------------------------------
    | Default model class for the user
    |------------------------------------------------------------------------------
    |
    | Here you may specify the class used as the user model. This class is 
    | called from the Role and RoleGroup models. If left then the default class
    | App\User will be used.
    |
    */
    'user_model' => env('USER_ROLES_USER_MODEL', 'App\User')

];