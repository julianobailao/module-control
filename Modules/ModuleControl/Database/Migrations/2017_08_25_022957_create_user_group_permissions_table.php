<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGroupPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_group_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_group_id')->unsigned();
            $table->integer('module_id')->unsigned();
            $table->integer('module_route_id')->unsigned()->nullable();
            $table->integer('module_route_action_id')->unsigned()->nullable();
            $table->boolean('grant_access')->default(false);
            $table->timestamps();

            $table->foreign('user_group_id')->references('id')->on('user_groups');
            $table->foreign('module_id')->references('id')->on('modules');
            $table->foreign('module_route_id')->references('id')->on('module_routes');
            $table->foreign('module_route_action_id')->references('id')->on('module_route_actions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_group_permissions');
    }
}
