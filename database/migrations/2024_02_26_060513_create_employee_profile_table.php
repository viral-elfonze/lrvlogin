<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_profile', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('emp_id')->unique();
            $table->string('emp_code')->unique();
            $table->string('emp_type');
            $table->string('relevent_exp');
            $table->string('current_location');
            $table->date('emp_start_date');
            $table->date('emp_end_date')->nullable();
            $table->string('attached_resume')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_profile');
    }
};
