<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsencesTable extends Migration
{
    public function up()
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users','id')->onUpdate('cascade')->onDelete('cascade');
            $table->date('absence_date');
            $table->string('reason');
            $table->softDeletes();
            $table->timestamps();
        });
    }

  
    public function down()
    {
        Schema::dropIfExists('absences');
    }
}
