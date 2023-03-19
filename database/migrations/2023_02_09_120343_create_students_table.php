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
        Schema::create('students', function (Blueprint $table) {
            $table->string('reg_no')->primary();
            $table->string('student_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('roll_no');
            $table->foreignId('department_id')->constrained('departments', 'department_id');
            $table->foreignId('class_id')->constrained('classes', 'class_id');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
