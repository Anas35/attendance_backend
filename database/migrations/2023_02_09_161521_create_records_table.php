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
        Schema::create('records', function (Blueprint $table) {
            $table->id('record_id');
            $table->string('reg_no');
            $table->foreignId('class_id')->constrained('classes', 'class_id');
            $table->foreignId('subject_id')->constrained('subjects', 'subject_id');
            $table->foreignId('teacher_id')->constrained('teachers', 'teacher_id');
            $table->boolean('is_present')->default(true);
            $table->dateTime('date')->useCurrent();
            $table->timestamps();
        });

        Schema::table('records',function (Blueprint $table){
            $table->foreign('reg_no')->references('reg_no')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
};
