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
        Schema::create('article_visitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('articles_id')->constrained('articles')->onDelete('cascade');
            $table->string('ip_address');
            $table->date('visit_date');
            $table->unique(['articles_id', 'ip_address', 'visit_date']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_visitors');
    }
};
