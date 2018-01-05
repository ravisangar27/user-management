<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permissionview.table_names');

        Schema::create($tableNames['action'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('display_name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create($tableNames['model'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('display_name');
            $table->timestamps();
            $table->softDeletes();
        });

       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permissionview.table_names');
     
        Schema::dropIfExists($tableNames['action']);
        Schema::dropIfExists($tableNames['model']);
     
    }
}
