<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSaleTypeInMilkSalesTable extends Migration
{
    public function up()
    {
        Schema::table('milk_sales', function (Blueprint $table) {
            // لتحويل العمود من enum إلى string:
            $table->string('sale_type', 10)->change();
        });
    }

    public function down()
    {
        Schema::table('milk_sales', function (Blueprint $table) {
            $table->enum('sale_type', ['ahali', 'maamel'])->change();
        });
    }
}

