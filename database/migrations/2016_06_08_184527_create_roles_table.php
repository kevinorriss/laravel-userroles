<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name')->unique();
            $table->text('description');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('deleted_at')->nullable();
        });

        if (DB::connection()->getDriverName() == 'pgsql')
        {
            DB::statement('ALTER TABLE roles ADD CONSTRAINT name_length CHECk(length(name) BETWEEN 3 AND 20)');
            DB::statement('ALTER TABLE roles ADD CONSTRAINT name_format CHECK(name ~ \'^[a-z]+(_[a-z]+)*$\')');
            DB::statement('ALTER TABLE roles ADD CONSTRAINT description_length CHECK (length(description) > 10)');
        }

        DB::table('roles')->insert([
            ['name' => 'role_browse',       'description' => 'Browse the roles'],
            ['name' => 'role_create',       'description' => 'Create a new role'],
            ['name' => 'role_edit',         'description' => 'Edit an existing role'],
            ['name' => 'role_delete',       'description' => 'Soft-delete an existing role'],
            ['name' => 'role_restore',      'description' => 'Restore a soft-deleted role'],
            ['name' => 'role_destroy',      'description' => 'Delete an existing role from the database'],
            ['name' => 'role_assign_user',  'description' => 'Assign a role to a user'],
            ['name' => 'role_assign_group', 'description' => 'Assign a role to a role group'],
            ['name' => 'role_revoke_user',  'description' => 'Revoke a role from a user'],
            ['name' => 'role_revoke_group', 'description' => 'Revoke a role from a group']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');
    }
}
