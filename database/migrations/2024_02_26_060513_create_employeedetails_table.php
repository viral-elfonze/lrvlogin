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
        Schema::create('employeedetails', function (Blueprint $table) {
            $table->id('employeeid');
            $table->string('employeecode')->nullable();
            $table->string('employeefirstname')->nullable();
            $table->string('employeedmiddlename')->nullable();
            $table->string('employeelastname')->nullable();
            $table->string('resumelink')->nullable();
            $table->string('employementtype', 50)->nullable();
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
        Schema::dropIfExists('employeedetails');
    }
};
