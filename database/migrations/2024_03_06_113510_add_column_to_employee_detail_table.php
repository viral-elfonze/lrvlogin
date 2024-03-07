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
        // Schema::table('employee_details', function (Blueprint $table) {
        //     $table->unsignedBigInteger('user_id');

        //     // Define foreign key constraint
        //     $table->foreign('user_id')->references('id')->on('users')
        //         ->onUpdate('NO ACTION')
        //         ->onDelete('NO ACTION');
        // });

        Schema::table('users', function (Blueprint $table) {
            $table->longText('api_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_detail', function (Blueprint $table) {
            //
        });
    }
};
