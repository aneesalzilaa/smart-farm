<?php

namespace App\Http\Controllers;

use App\Models\MilkProduction;
use App\Models\MilkSale;
use App\Models\Pricing;
use App\Models\MilkSupplierDelivery;
use App\Models\MilkSurplus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class MilkProductionController extends Controller
{
    /**
     * عرض قائمة الإنتاجات من الموردين.
     */
   public function index(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // إنتاج الأبقار
    $milkProductionsQuery = MilkProduction::with('cow')->orderBy('date', 'desc');

    if ($startDate) {
        $milkProductionsQuery->whereDate('date', '>=', $startDate);
    }

    if ($endDate) {
        $milkProductionsQuery->whereDate('date', '<=', $endDate);
    }

    $milkProductions = $milkProductionsQuery->get();

    // كميات الموردين
    $query = MilkSupplierDelivery::query()
        ->join('milk_suppliers', 'milk_supplier_deliveries.milk_supplier_id', '=', 'milk_suppliers.id')
        ->select('milk_suppliers.name', DB::raw('SUM(milk_supplier_deliveries.morning_quantity + milk_supplier_deliveries.evening_quantity) as total_quantity'))
        ->groupBy('milk_suppliers.name');

    if ($startDate) {
        $query->whereDate('milk_supplier_deliveries.date', '>=', $startDate);
    }
    if ($endDate) {
        $query->whereDate('milk_supplier_deliveries.date', '<=', $endDate);
    }

    $supplierQuantities = $query->get();

    return view('dashboardcomponents.milkproductions.index', compact('milkProductions', 'supplierQuantities'));
}

    public function create()
    {
        return view('dashboardcomponents.milkproductions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cow_id' => [
                'required',
                'exists:cows,id',
                Rule::unique('milk_productions')->where(function ($query) use ($request) {
                    return $query->where('date', $request->date)
                                 ->where('cow_id', $request->cow_id);
                }),
            ],
            'date' => 'required|date',
            'period' => 'required|in:morning,evening',
            'quantity' => 'required|numeric|min:0',
        ]);

        $morning_quantity = $request->period === 'morning' ? $request->quantity : 0;
        $evening_quantity = $request->period === 'evening' ? $request->quantity : 0;

        $average_price = Pricing::avg('price');
        $total = ($morning_quantity + $evening_quantity) * $average_price;

        MilkProduction::create([
            'cow_id' => $request->cow_id,
            'date' => $request->date,
            'morning_amount' => $morning_quantity,
            'evening_amount' => $evening_quantity,
            'price' => $average_price,
            'total' => $total,
        ]);

        return redirect()->route('milkproductions.index')->with('success', 'تمت إضافة بيانات الإنتاج بنجاح');
    }

    public function show(MilkProduction $milkProduction)
    {
        return view('dashboardcomponents.milkproductions.show', compact('milkProduction'));
    }

    public function edit(MilkProduction $milkProduction)
    {
        return view('dashboardcomponents.milkproductions.edit', compact('milkProduction'));
    }

    public function update(Request $request, MilkProduction $milkProduction)
    {
        $request->validate([
            'cow_id' => 'required|exists:cows,id',
            'date' => 'required|date',
            'period' => 'required|in:morning,evening',
            'quantity' => 'required|numeric|min:0',
        ]);

        $average_price = Pricing::avg('price');

        $morning_quantity = $milkProduction->morning_amount;
        $evening_quantity = $milkProduction->evening_amount;

        if ($request->period === 'morning') {
            $morning_quantity = $request->quantity;
        } elseif ($request->period === 'evening') {
            $evening_quantity = $request->quantity;
        }

        $total = ($morning_quantity + $evening_quantity) * $average_price;

        $milkProduction->update([
            'cow_id' => $request->cow_id,
            'date' => $request->date,
            'morning_amount' => $morning_quantity,
            'evening_amount' => $evening_quantity,
            'price' => $average_price,
            'total' => $total,
        ]);

        return redirect()->route('milkproductions.index')->with('success', 'تم تحديث بيانات الإنتاج بنجاح');
    }

    public function destroy(MilkProduction $milkProduction)
    {
        $milkProduction->delete();
        return redirect()->route('milkproductions.index')->with('success', 'تم حذف بيانات الإنتاج بنجاح');
    }

    public function dailyProduction(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $start_date = $request->input('start_date', $today);
        $end_date = $request->input('end_date', $today);

        if (Carbon::parse($start_date)->gt(Carbon::parse($end_date))) {
            [$start_date, $end_date] = [$end_date, $start_date];
        }

        $productions = MilkProduction::with('cow')
            ->whereBetween('date', [$start_date, $end_date])
            ->orderBy('date', 'asc')
            ->get();

        $supplierDeliveries = MilkSupplierDelivery::with('milkSupplier')
            ->whereBetween('date', [$start_date, $end_date])
            ->orderBy('date', 'asc')
            ->get();

        $supplierQuantities = MilkSupplierDelivery::join('milk_suppliers', 'milk_supplier_deliveries.milk_supplier_id', '=', 'milk_suppliers.id')
            ->whereBetween('milk_supplier_deliveries.date', [$start_date, $end_date])
            ->select(
                'milk_suppliers.name',
                DB::raw('SUM(milk_supplier_deliveries.morning_quantity + milk_supplier_deliveries.evening_quantity) as total_quantity')
            )
            ->groupBy('milk_suppliers.name')
            ->get();

        $totalProduction = $productions->sum(fn($item) => ($item->morning_amount ?? 0) + ($item->evening_amount ?? 0));
        $totalSupplierMilk = $supplierDeliveries->sum(fn($item) => ($item->morning_quantity ?? 0) + ($item->evening_quantity ?? 0));

        $milkSalesByDate = MilkSale::selectRaw('DATE(created_at) as sale_date, SUM(quantity) as total_sold')
            ->whereBetween('created_at', [
                Carbon::parse($start_date)->startOfDay(),
                Carbon::parse($end_date)->endOfDay()
            ])
            ->groupBy('sale_date')
            ->get()
            ->keyBy('sale_date');

        $soldMilk = $milkSalesByDate->sum('total_sold');

        $yesterday = Carbon::parse($start_date)->subDay()->toDateString();
        $milkSurplusYesterday = MilkSurplus::whereDate('date', $yesterday)->first();
        $surplusYesterdayQuantity = $milkSurplusYesterday ? $milkSurplusYesterday->quantity : 0;

        $remainingMilk = ($totalProduction + $totalSupplierMilk + $surplusYesterdayQuantity) - $soldMilk;

        return view('dashboardcomponents.milkproductions.daily', compact(
            'productions',
            'supplierDeliveries',
            'totalProduction',
            'totalSupplierMilk',
            'start_date',
            'end_date',
            'milkSalesByDate',
            'soldMilk',
            'surplusYesterdayQuantity',
            'remainingMilk',
            'supplierQuantities'
        ));
    }
}
