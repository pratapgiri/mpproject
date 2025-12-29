<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_devices', function (Blueprint $table) {
            $table->increments('id');
            // Change 'unsignedInteger' to 'unsignedBigInteger' to match the 'id' column in 'users'
            $table->unsignedBigInteger('user_id');
            $table->string('device_type')->nullable();
            $table->string('device_token')->nullable();
            $table->string('device_unique_id', 250)->nullable();
            $table->timestamps(0); // This includes both 'created_at' and 'updated_at' columns
            
            // Add the foreign key constraint
            $table->foreign('user_id', 'delete_user_devices')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_devices');
    }
}
