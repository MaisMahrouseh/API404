<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntriesTable extends Migration
{
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users','id')->onUpdate('cascade')->onDelete('cascade');
            $table->dateTime('login_date_time')->nullable();
            $table->dateTime('logout_date_time')->nullable();
            $table->integer('status');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('entries');
    }
}
