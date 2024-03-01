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
        Schema::create('employee_skill_matrix', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('skill_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->integer('relevantexp')->nullable();
            $table->integer('competency')->nullable();
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('skill_id')->references('skill_id')->on('skills')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');

            $table->foreign('employee_id')->references('employee_id')->on('employee_details')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_skill_matrix');
    }
};
