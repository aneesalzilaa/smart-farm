<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilkProductionsTable extends Migration
{
    public function up()
    {
        Schema::create('milk_productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cow_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->decimal('morning_amount', 8, 2)->default(0);
            $table->decimal('evening_amount', 8, 2)->default(0);
            $table->timestamps();

            $table->unique(['cow_id', 'date']); // لكل بقرة يوم واحد فقط
        });
    }

    public function down()
    {
        Schema::dropIfExists('milk_productions');
    }
}
