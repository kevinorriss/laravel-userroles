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
