<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleGroupGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_group_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_group_id');
            $table->foreign('role_group_id')->references('id')->on('role_groups');
            $table->integer('sub_role_group_id');
            $table->foreign('sub_role_group_id')->references('id')->on('role_groups');
            $table->timestampTz('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestampTz('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestampTz('deleted_at')->nullable();
            $table->index('deleted_at');
            $table->unique(['role_group_id', 'sub_role_group_id']);
        });

        DB::statement('ALTER TABLE role_group_groups ADD CONSTRAINT self_reference CHECK(role_group_id <> sub_role_group_id)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('role_group_groups');
    }
}
