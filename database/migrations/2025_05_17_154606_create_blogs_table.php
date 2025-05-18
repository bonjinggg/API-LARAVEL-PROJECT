<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id('blog_id'); // ✅ custom primary key
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('gallery_id');
            $table->timestamps();

            $table->foreign('gallery_id')->references('gallery_id')->on('galleries')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
