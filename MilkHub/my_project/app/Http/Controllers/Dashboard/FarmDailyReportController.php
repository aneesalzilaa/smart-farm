<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\MilkProduction;
use App\Models\MilkSupplierDelivery;
use App\Models\MilkSale;
use App\Models\MilkSurplus;
use App\Models\CowFeed;

class FarmDailyReportController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $start_date = $request->input('start_date', $today);
        $end_date = $request->input('end_date', $today);

        if (Carbon::parse($start_date)->gt(Carbon::parse($end_date))) {
            [$start_date, $end_date] = [$end_date, $start_date];
        }

        // بيانات إنتاج الحليب
        $productions = MilkProduction::with('cow')
            ->whereBetween('date', [$start_date, $end_date])
            ->orderBy('date', 'asc')
            ->get();

        $totalProduction = $productions->sum(function($item) {
            return ($item->morning_amount ?? 0) + ($item->evening_amount ?? 0);
        });

        // بيانات توريدات الموردين (مجموع الكميات الصباحية والمسائية)
        $supplierDeliveries = MilkSupplierDelivery::with('milkSupplier')
            ->whereBetween('date', [$start_date, $end_date])
            ->orderBy('date', 'asc')
            ->get();

        $totalSupplierMilk = $supplierDeliveries->sum(function($item) {
            return ($item->morning_quantity ?? 0) + ($item->evening_quantity ?? 0);
        });

        // حساب إجمالي كمية الحليب لكل مورد
        $supplierTotals = $supplierDeliveries->groupBy('milk_supplier_id')->map(function ($group) {
            $totalQuantity = $group->sum(function ($item) {
                return ($item->morning_quantity ?? 0) + ($item->evening_quantity ?? 0);
            });

            return [
                'supplier' => $group->first()->milkSupplier,
                'total_quantity' => $totalQuantity,
            ];
        })->values();

        // بيانات مبيعات الحليب
        $milkSales = MilkSale::whereBetween('created_at', [
                Carbon::parse($start_date)->startOfDay(),
                Carbon::parse($end_date)->endOfDay()
            ])
            ->orderBy('created_at', 'asc')
            ->get();

        $soldMilk = $milkSales->sum('quantity');

        // كمية فائض الحليب لليوم السابق
        $yesterday = Carbon::parse($start_date)->subDay()->toDateString();
        $milkSurplusYesterday = MilkSurplus::whereDate('date', $yesterday)->first();
        $surplusYesterdayQuantity = $milkSurplusYesterday ? $milkSurplusYesterday->quantity : 0;

        // كمية الحليب المتبقية
        $remainingMilk = $surplusYesterdayQuantity + $totalProduction + $totalSupplierMilk - $soldMilk;

        // حساب تكلفة الإطعام من CowFeed
        $totalFeedCost = CowFeed::whereBetween('date', [$start_date, $end_date])->sum('total_price');

        // حساب الإيرادات الكلية من بيانات المبيعات مباشرةً (مجموع حقل total)
        $totalRevenue = $milkSales->sum('total');

        // حساب صافي الربح
        $profit = $totalRevenue - $totalFeedCost;

        return view('dashboardcomponents.reports.daily-farm-report', compact(
            'start_date', 'end_date',
            'productions', 'supplierDeliveries', 'milkSales',
            'totalProduction', 'totalSupplierMilk', 'soldMilk',
            'surplusYesterdayQuantity', 'remainingMilk',
            'totalFeedCost', 'totalRevenue', 'profit',
            'supplierTotals'
        ));
    }
}
