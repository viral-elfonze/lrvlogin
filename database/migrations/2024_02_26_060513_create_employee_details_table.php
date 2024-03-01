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
        Schema::create('employee_details', function (Blueprint $table) {
            $table->id('employee_id');
            $table->string('employee_code')->nullable();
            $table->string('employee_firstname')->nullable();
            $table->string('employee_middlename')->nullable();
            $table->string('employee_lastname')->nullable();
            $table->string('resumelink')->nullable();
            $table->string('employement_type', 50)->nullable();
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();
            $table->string('location', 100)->nullable();
            $table->integer('totalexp')->nullable();
            $table->integer('relevantexp')->nullable();
            $table->boolean('isactive')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_details');
    }
};
