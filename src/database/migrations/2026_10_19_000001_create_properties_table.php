<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['ban', 'thue']);
            $table->enum('category', ['nha', 'dat', 'can-ho']);
            $table->unsignedBigInteger('price');
            $table->decimal('area', 8, 2);
            $table->unsignedTinyInteger('bedrooms')->nullable();
            $table->string('city');
            $table->string('district');
            $table->string('address')->nullable();
            $table->text('description');
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->timestamps();
            $table->index(['type', 'category', 'city']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
