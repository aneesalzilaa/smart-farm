<?php

namespace App\Http\Controllers;

use App\Models\MilkSale;
use App\Models\MilkProduction;
use App\Models\Customer;
use App\Models\Pricing;
use App\Models\MilkSupplierDelivery;
use App\Models\MilkSurplus; // موديل الكمية الفائضة
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MilkSaleController extends Controller
{
    public function index()
    {
        // عرض عمليات البيع مرتبة من الأحدث للأقدم
        $sales = MilkSale::with('customer')->latest()->paginate(15);
        return view('dashboardcomponents.milksales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::all();
        $pricings = Pricing::all();
        return view('dashboardcomponents.milksales.create', compact('customers', 'pricings'));
    }

    // دالة لحساب وتحديث الفائض يومياً
    private function updateSurplusForDate(string $date)
    {
        // إجمالي إنتاج اليوم (الصباح + المساء)
        $totalProduction = MilkProduction::whereDate('date', $date)
            ->sum(DB::raw('morning_amount + evening_amount'));

        // كمية الموردين اليوم (جمع الصباح والمساء)
        $supplierQuantity = MilkSupplierDelivery::whereDate('date', $date)
            ->sum(DB::raw('morning_quantity + evening_quantity'));

        // كمية البيع اليوم
        $totalSold = MilkSale::whereDate('created_at', $date)
            ->sum('quantity');

        // كمية الفائض من اليوم السابق
        $previousSurplus = MilkSurplus::where('date', '<', $date)
            ->orderBy('date', 'desc')
            ->first();

        $prevQuantity = $previousSurplus ? $previousSurplus->quantity : 0;

        // حساب الفائض الجديد
        $newSurplusQuantity = $totalProduction + $supplierQuantity + $prevQuantity - $totalSold;

        if ($newSurplusQuantity < 0) {
            $newSurplusQuantity = 0; // لا يمكن أن يكون الفائض سالباً
        }

        // تحديث أو إنشاء سجل الفائض لهذا التاريخ
        MilkSurplus::updateOrCreate(
            ['date' => $date],
            ['quantity' => $newSurplusQuantity]
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_type' => 'required|in:اهالي,معامل',
            'quantity' => 'required|numeric|min:0.1',
            'price' => 'required|numeric|min:0',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        if ($request->sale_type === 'معامل' && !$request->customer_id) {
            return back()->withErrors(['customer_id' => 'يجب اختيار العميل عند البيع للمعامل'])->withInput();
        }

        $today = Carbon::today()->toDateString();

        // اجمالي الفائض + الإنتاج + التوريدات = الكمية المتاحة
        $previousSurplus = MilkSurplus::where('date', '<', $today)
            ->orderBy('date', 'desc')
            ->first();

        $prevQuantity = $previousSurplus ? $previousSurplus->quantity : 0;

        $totalProduction = MilkProduction::whereDate('date', $today)
            ->sum(DB::raw('morning_amount + evening_amount'));

        $supplierQuantity = MilkSupplierDelivery::whereDate('date', $today)
            ->sum(DB::raw('morning_quantity + evening_quantity'));

        $totalAvailable = $totalProduction + $supplierQuantity + $prevQuantity;

        // كمية البيع اليوم بالفعل
        $totalSold = MilkSale::whereDate('created_at', $today)->sum('quantity');

        $availableQuantity = $totalAvailable - $totalSold;

        if ($request->quantity > $availableQuantity) {
            return back()->withErrors([
                'quantity' => 'الكمية المطلوبة أكبر من الكمية المتاحة (' . $availableQuantity . ' لتر).'
            ])->withInput();
        }

        DB::transaction(function () use ($request, $today) {
            $total = $request->quantity * $request->price;

            MilkSale::create([
                'sale_type' => $request->sale_type,
                'customer_id' => $request->sale_type === 'معامل' ? $request->customer_id : null,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'total' => $total,
            ]);

            // تحديث الفائض بعد البيع
            $this->updateSurplusForDate($today);
        });

        return redirect()->route('milksales.index')->with('success', 'تمت إضافة عملية البيع بنجاح.');
    }

    public function edit($id)
    {
        $sale = MilkSale::findOrFail($id);
        $customers = Customer::all();
        $pricings = Pricing::all();
        return view('dashboardcomponents.milksales.edit', compact('sale', 'customers', 'pricings'));
    }

    public function update(Request $request, $id)
    {
        $sale = MilkSale::findOrFail($id);

        $request->validate([
            'sale_type' => 'required|in:اهالي,معامل',
            'customer_id' => 'nullable|exists:customers,id',
            'quantity' => 'required|numeric|min:0.01',
            'price' => 'required|numeric|min:0',
        ]);

        if ($request->sale_type === 'معامل' && !$request->customer_id) {
            return back()->withErrors(['customer_id' => 'يجب اختيار العميل عند البيع للمعامل'])->withInput();
        }

        $today = Carbon::today()->toDateString();

        // كمية الفائض السابقة + الإنتاج + التوريدات = الكمية المتاحة
        $previousSurplus = MilkSurplus::where('date', '<', $today)
            ->orderBy('date', 'desc')
            ->first();

        $prevQuantity = $previousSurplus ? $previousSurplus->quantity : 0;

        $totalProduction = MilkProduction::whereDate('date', $today)
            ->sum(DB::raw('morning_amount + evening_amount'));

        $supplierQuantity = MilkSupplierDelivery::whereDate('date', $today)
            ->sum(DB::raw('morning_quantity + evening_quantity'));

        $totalAvailable = $totalProduction + $supplierQuantity + $prevQuantity;

        // كمية البيع اليوم ما عدا السجل الحالي
        $totalSoldExceptCurrent = MilkSale::whereDate('created_at', $today)
            ->where('id', '<>', $id)
            ->sum('quantity');

        $availableQuantity = $totalAvailable - $totalSoldExceptCurrent;

        if ($request->quantity > $availableQuantity) {
            return back()->withErrors(['quantity' => 'الكمية المطلوبة أكبر من كمية الحليب المتوفرة اليوم'])->withInput();
        }

        $total = $request->quantity * $request->price;

        DB::transaction(function () use ($sale, $request, $today, $total) {
            $sale->update([
                'sale_type' => $request->sale_type,
                'customer_id' => $request->sale_type === 'معامل' ? $request->customer_id : null,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'total' => $total,
            ]);

            // تحديث الفائض بعد تعديل البيع
            $this->updateSurplusForDate($today);
        });

        return redirect()->route('milksales.index')->with('success', 'تم تحديث بيانات البيع بنجاح');
    }

    public function destroy($id)
    {
        $sale = MilkSale::findOrFail($id);

        DB::transaction(function () use ($sale) {
            $sale->delete();

            // تحديث الفائض بعد الحذف
            $today = Carbon::today()->toDateString();
            $this->updateSurplusForDate($today);
        });

        return redirect()->route('milksales.index')->with('success', 'تم حذف البيع بنجاح');
    }

    public function report(Request $request)
    {
        $startDate = $request->input('start_date') ?? now()->startOfMonth()->toDateString();
        $endDate = $request->input('end_date') ?? now()->endOfMonth()->toDateString();
        $customerName = $request->input('customer_name'); // اسم المعمل من الفلتر

        // جلب العملاء (مثلاً من جدول customers)
        $customers = Customer::all();

        $salesQuery = MilkSale::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc');

        // إذا تم اختيار عميل معين، فلتر حسب اسمه أو id
        if ($customerName) {
            $salesQuery->whereHas('customer', function($query) use ($customerName) {
                $query->where('name', $customerName);
            });
        }

        $sales = $salesQuery->get();

        $totalQuantity = $sales->sum('quantity');
        $totalRevenue = $sales->sum(function($sale) {
            return $sale->quantity * $sale->price;
        });

        $byType = $sales->groupBy('sale_type')->map(function ($group) {
            return [
                'quantity' => $group->sum('quantity'),
                'revenue' => $group->sum(function($sale) {
                    return $sale->quantity * $sale->price;
                }),
            ];
        });

        return view('dashboardcomponents.milksales.report', compact(
            'sales', 'totalQuantity', 'totalRevenue', 'byType', 'startDate', 'endDate', 'customers', 'customerName'
        ));
    }
}
