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
        Schema::create('cow_feeds', function (Blueprint $table) {
       $table->id();
    $table->foreignId('cow_id')->constrained()->onDelete('cascade');
    $table->foreignId('feed_id')->constrained()->onDelete('cascade');
    $table->decimal('morning_quantity', 8, 2)->default(0);
    $table->decimal('evening_quantity', 8, 2)->default(0);
    $table->date('date');
    $table->decimal('price', 8, 2); // السعر الثابت
    $table->decimal('total_price', 10, 2)->default(0); // مجموع السعر
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cow_feeds');
    }
};
