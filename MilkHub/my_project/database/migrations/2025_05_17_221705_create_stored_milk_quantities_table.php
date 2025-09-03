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
        Schema::create('stored_milk_quantities', function (Blueprint $table) {
            $table->id();
            $table->date('stored_date')->unique();  // تاريخ التخزين (واحد لكل يوم)
            $table->decimal('quantity', 8, 2)->default(0); // كمية الحليب المفرزة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stored_milk_quantities');
    }
};
