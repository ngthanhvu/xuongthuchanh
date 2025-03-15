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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories', 'id');
            $table->string('name', 255);
            $table->string('description', 255)->nullable();
            $table->decimal('original_price', 10, 2);
            $table->decimal('discounted_price', 10, 2)->nullable();
            $table->integer('total_lessons')->nullable();
            $table->string('total_duration', 20)->nullable();
            $table->enum('status', ['new', 'ongoing', 'completed'])->default('new');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
