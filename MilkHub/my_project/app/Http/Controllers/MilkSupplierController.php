<?php

namespace App\Http\Controllers;

use App\Models\MilkSupplier;
use App\Models\MilkSupplierDelivery;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MilkSupplierController extends Controller
{
    public function index()
    {
        $suppliers = MilkSupplier::latest()->get();
        return view('dashboardcomponents.milk_suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('dashboardcomponents.milk_suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        MilkSupplier::create($request->only(['name', 'phone']));
        return redirect()->route('milk_suppliers.index')->with('success', 'تم إضافة المورد بنجاح');
    }

    public function edit(MilkSupplier $milkSupplier)
    {
        return view('dashboardcomponents.milk_suppliers.edit', compact('milkSupplier'));
    }

    public function update(Request $request, MilkSupplier $milkSupplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $milkSupplier->update($request->only(['name', 'phone']));
        return redirect()->route('milk_suppliers.index')->with('success', 'تم تحديث بيانات المورد');
    }

    public function destroy(MilkSupplier $milkSupplier)
    {
        $milkSupplier->delete();
        return redirect()->route('milk_suppliers.index')->with('success', 'تم حذف المورد');
    }
public function report(Request $request)
{
    $query = MilkSupplier::query();

    // التصفية حسب الاسم
    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    // التصفية حسب المورد
    if ($request->filled('supplier_id')) {
        $query->where('id', $request->supplier_id);
    }

    $from = $request->input('from');
    $to = $request->input('to');

    // تلخيص الكميات الصباحية والمسائية خلال الفترة
    $query->withSum(['deliveries as deliveries_sum_morning' => function ($q) use ($from, $to) {
        if ($from) $q->whereDate('date', '>=', $from);
        if ($to) $q->whereDate('date', '<=', $to);
    }], 'morning_quantity');

    $query->withSum(['deliveries as deliveries_sum_evening' => function ($q) use ($from, $to) {
        if ($from) $q->whereDate('date', '>=', $from);
        if ($to) $q->whereDate('date', '<=', $to);
    }], 'evening_quantity');

    // تلخيص الإجمالي (المبلغ)
    $query->withSum(['deliveries as deliveries_sum_total' => function ($q) use ($from, $to) {
        if ($from) $q->whereDate('date', '>=', $from);
        if ($to) $q->whereDate('date', '<=', $to);
    }], 'total');

    $suppliers = $query->get();

    // حساب مجموع الكميات (صباحية + مسائية) لكل مورد
    foreach ($suppliers as $supplier) {
        $supplier->deliveries_sum_quantity =
            ($supplier->deliveries_sum_morning ?? 0) + ($supplier->deliveries_sum_evening ?? 0);
    }

    // حساب الإجماليات الكلية
    $totalAmount = $suppliers->sum('deliveries_sum_total');

    $totalQuantity = $suppliers->sum(function ($supplier) {
        return ($supplier->deliveries_sum_morning ?? 0) + ($supplier->deliveries_sum_evening ?? 0);
    });

    // قائمة الموردين للاختيار في الفلتر
    $allSuppliers = MilkSupplier::select('id', 'name')->orderBy('name')->get();

    return view('dashboardcomponents.milk_suppliers.report', compact(
        'suppliers',
        'allSuppliers',
        'totalAmount',
        'totalQuantity'
    ));
}

}

