<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timesheets', function (Blueprint $table) {
            $table->date('date');
            $table->bigInteger('user_id')->unsigned();
            $table->text('difficult')->nullable();
            $table->text('schedule')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('lines', function (Blueprint $table) {
            $table->bigInteger('timesheet_id')->unsigned();
            $table->bigInteger('task_id')->unsigned();
            $table->text('content');
            $table->foreign('timesheet_id')->references('id')->on('timesheets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
