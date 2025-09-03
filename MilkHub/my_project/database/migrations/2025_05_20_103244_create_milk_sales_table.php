<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilkSalesTable extends Migration
{
    public function up()
    {
        Schema::create('milk_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('milk_production_id')->constrained()->onDelete('cascade');
            $table->enum('sale_type', ['ahali', 'maamel']);
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('quantity', 8, 2);
            $table->decimal('price', 8, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('milk_sales');
    }
}
