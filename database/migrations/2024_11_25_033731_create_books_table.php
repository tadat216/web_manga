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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('author_name')->nullable();
            $table->string('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('avatar_image')->nullable();
            $table->enum('status', ['incoming', 'ongoing', 'compelete']);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_premium')->default(false);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
