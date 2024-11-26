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
        Schema::table('books', function (Blueprint $table) {
            $table->text('description')->change();
            $table->string('cover_image', 500)->change();
            $table->string('avatar_image', 500)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('description', 255)->change();
            $table->string('cover_image', 255)->change(); 
            $table->string('avatar_image', 255)->change();
        });
    }
};
