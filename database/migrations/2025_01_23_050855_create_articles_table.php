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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->uniqid();
            $table->foreignId('category_article_id')->constrained('category_articles')->onDelete('cascade');
            $table->longText('content');
            $table->string('image');
            $table->date('publish_date')->nullable();
            $table->enum('status', ['draft', 'published', 'rejected'])->default('draft');
            $table->unsignedInteger('click_count')->default(0);
            $table->foreignId('repoter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('editor_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
