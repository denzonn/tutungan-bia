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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->string('image');
            $table->enum('status', ['draft', 'published', 'rejected'])->default('draft');
            $table->unsignedInteger('click_count')->default(0);
            $table->foreignId('contributor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('editor_id')->constrained('users')->onDelete('cascade')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};