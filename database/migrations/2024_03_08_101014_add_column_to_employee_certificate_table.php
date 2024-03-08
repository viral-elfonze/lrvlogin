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
        Schema::table('employee_certifications', function (Blueprint $table) {
            $table->dropForeign('employee_certifications_employee_id_foreign');
            $table->dropColumn('employee_id');

            $table->unsignedBigInteger('employee_skill_matrix_id')->after('id');

            $table->foreign('employee_skill_matrix_id')->references('id')->on('employee_skill_matrix')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_certifications', function (Blueprint $table) {
            //
        });
    }
};
