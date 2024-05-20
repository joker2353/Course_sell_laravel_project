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
            $table->string('title');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('author');
            $table->string('price')->nullable();
            $table->integer('seat');
            $table->string('duration');
            $table->text('description')->nullable();
            $table->text('benefits')->nullable();
            $table->text('prerequisite')->nullable();
            $table->string('link')->nullable();
            $table->text('keywords')->nullable();
            $table->string('experience');
            $table->integer('status');
            $table->integer('isFeatured');
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
