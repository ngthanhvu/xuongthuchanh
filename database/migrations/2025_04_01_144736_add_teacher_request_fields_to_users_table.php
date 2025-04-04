<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Trong file migration
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_teacher_requested')->default(false);
            $table->string('teacher_request_status')->nullable();
            $table->string('qualifications')->nullable();
            $table->text('teacher_request_message')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
