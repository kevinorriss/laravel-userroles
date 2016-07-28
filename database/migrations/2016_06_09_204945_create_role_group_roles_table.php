<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleGroupRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_group_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->integer('role_group_id');
            $table->foreign('role_group_id')->references('id')->on('role_groups');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unique(['role_id', 'role_group_id']);
        });

        // Role Browser
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_browse', 'role_browser']);

        // Role Admin
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_create', 'role_admin']);
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_edit', 'role_admin']);
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_delete', 'role_admin']);
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_restore', 'role_admin']);
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_destroy', 'role_admin']);

        // Role Group Browser
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_group_browse', 'role_group_browser']);

        // Role Group Admin
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_group_create', 'role_group_admin']);
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_group_edit', 'role_group_admin']);
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_group_delete', 'role_group_admin']);
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_group_restore', 'role_group_admin']);
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_group_destroy', 'role_group_admin']);
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_group_assign_group', 'role_group_admin']);
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_assign_group', 'role_group_admin']);

        // User Role Browser
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'user_role_browser', 'user_role_browse']);

        // User Role Admin
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_assign_user', 'user_role_admin']);
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_group_assign_user', 'user_role_admin']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_group_roles');
    }
}
