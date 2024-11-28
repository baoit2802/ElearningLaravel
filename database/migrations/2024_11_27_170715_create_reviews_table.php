<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained()->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned()->comment('Rating from 1 to 5');
            $table->text('comment')->nullable();
            $table->foreignId('video_id')->nullable()->constrained('videos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

