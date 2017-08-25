<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleRouteActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_route_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('module_route_id')->unsigned();
            $table->string('namespace');
            $table->string('class_name');
            $table->string('method');
            $table->timestamps();

            $table->foreign('module_route_id')->references('id')->on('module_routes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_route_actions');
    }
}
