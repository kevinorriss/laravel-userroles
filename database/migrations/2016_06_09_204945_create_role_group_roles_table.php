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
            $table->timestamp('deleted_at')->nullable();
            $table->unique(['role_id', 'role_group_id']);
        });

        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_browse', 'role_browser']);
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
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_assign_user', 'role_admin']);
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_assign_group', 'role_admin']);
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_revoke_user', 'role_admin']);
        DB::insert("INSERT INTO role_group_roles (role_id, role_group_id) SELECT (SELECT id FROM roles WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_revoke_group', 'role_admin']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('role_group_roles');
    }
}
