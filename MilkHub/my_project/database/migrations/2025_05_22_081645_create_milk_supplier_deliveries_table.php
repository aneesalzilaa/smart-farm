<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
Schema::create('milk_supplier_deliveries', function (Blueprint $table) {
    $table->id();
    $table->foreignId('milk_supplier_id')->constrained()->onDelete('cascade');
    $table->date('date');
    $table->float('morning_quantity')->default(0);
    $table->float('evening_quantity')->default(0);
    $table->float('price_per_liter')->default(0);
    $table->float('total')->default(0);
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('milk_supplier_deliveries');
    }
};
