<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyMilkSalesTableRemoveProductionId extends Migration
{
    public function up()
    {
        Schema::table('milk_sales', function (Blueprint $table) {
            // حذف العمود milk_production_id مع المفتاح الخارجي
            $table->dropForeign(['milk_production_id']);
            $table->dropColumn('milk_production_id');
        });
    }

    public function down()
    {
        Schema::table('milk_sales', function (Blueprint $table) {
            // إعادة إضافة العمود والمفتاح الخارجي في حالة التراجع
            $table->foreignId('milk_production_id')->constrained()->onDelete('cascade');
        });
    }
}

