<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMilkSurplusTable extends Migration
{
    public function up()
    {
        Schema::create('milk_surplus', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // تاريخ الفائض (يوم الإنتاج أو اليوم الذي تم تأجيله)
            $table->decimal('quantity', 8, 2)->default(0); // كمية الحليب الفائضة
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('milk_surplus');
    }
}
