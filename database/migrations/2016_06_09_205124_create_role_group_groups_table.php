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
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unique(['role_group_id', 'sub_role_group_id']);
        });

        if (DB::connection()->getDriverName() == 'pgsql')
        {
            DB::statement('ALTER TABLE role_group_groups ADD CONSTRAINT self_reference CHECK(role_group_id <> sub_role_group_id)');

            DB::statement(
                "CREATE FUNCTION role_group_groups_infinite_loop_check() RETURNS trigger AS
                $$
                DECLARE
                    has_loop BOOLEAN;
                BEGIN
                    WITH RECURSIVE search_graph(role_group_id, sub_role_group_id, depth, path, found) AS
                    (
                        SELECT 
                            t.role_group_id,
                            t.sub_role_group_id, 
                            1,
                            ARRAY[t.role_group_id],
                            FALSE
                        FROM role_group_groups t
                        UNION ALL
                        SELECT 
                            t.role_group_id, 
                            t.sub_role_group_id, 
                            sg.depth + 1,
                            path || t.role_group_id,
                            t.role_group_id = ANY(path)
                        FROM role_group_groups t, search_graph sg
                        WHERE t.role_group_id = sg.sub_role_group_id 
                        AND NOT sg.found
                    )
                    SELECT INTO has_loop 
                        COUNT(*) > 0 
                    FROM search_graph 
                    WHERE search_graph.found;

                    IF (has_loop) THEN
                        RAISE EXCEPTION 'Infinite loop found in table: role_group_groups';
                    END IF;

                    RETURN NEW;
                END;
                $$
                LANGUAGE plpgsql");

            DB::statement(
                "CREATE CONSTRAINT TRIGGER role_group_groups_after_insert_update AFTER INSERT OR UPDATE ON role_group_groups DEFERRABLE INITIALLY IMMEDIATE
                    FOR EACH ROW EXECUTE PROCEDURE role_group_groups_infinite_loop_check()");
        }

        DB::insert("INSERT INTO role_group_groups (role_group_id, sub_role_group_id) SELECT (SELECT id FROM role_groups WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_admin', 'role_browser']);
        DB::insert("INSERT INTO role_group_groups (role_group_id, sub_role_group_id) SELECT (SELECT id FROM role_groups WHERE name=?), (SELECT id FROM role_groups WHERE name=?)", [
            'role_group_admin', 'role_group_browser']);
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
