<?php

namespace App\Http\Controllers;

use App\Models\MilkSupplierDelivery;
use App\Models\MilkSupplier;
use Illuminate\Http\Request;

class MilkSupplierDeliveryController extends Controller
{
    public function index()
    {
        $deliveries = MilkSupplierDelivery::with('milkSupplier')->paginate(15);
        return view('dashboardcomponents.milk_supplier_deliveries.index', compact('deliveries'));
    }

    public function create()
    {
        $suppliers = MilkSupplier::all();
        return view('dashboardcomponents.milk_supplier_deliveries.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'milk_supplier_id'   => 'required|exists:milk_suppliers,id',
            'date'               => 'required|date',
            'morning_quantity'   => 'required|numeric|min:0',
            'evening_quantity'   => 'required|numeric|min:0',
            'price_per_liter'    => 'required|numeric|min:0',
        ]);

        $data['total'] = ($data['morning_quantity'] + $data['evening_quantity']) * $data['price_per_liter'];

        MilkSupplierDelivery::create($data);

        return redirect()->route('milk_supplier_deliveries.index')
                         ->with('success', 'تم إضافة التسليم بنجاح');
    }

    public function edit(MilkSupplierDelivery $milkSupplierDelivery)
    {
        $suppliers = MilkSupplier::all();
        return view('dashboardcomponents.milk_supplier_deliveries.edit', [
            'delivery' => $milkSupplierDelivery,
            'suppliers' => $suppliers,
        ]);
    }

    public function update(Request $request, MilkSupplierDelivery $milkSupplierDelivery)
    {
        $data = $request->validate([
            'milk_supplier_id'   => 'required|exists:milk_suppliers,id',
            'date'               => 'required|date',
            'morning_quantity'   => 'required|numeric|min:0',
            'evening_quantity'   => 'required|numeric|min:0',
            'price_per_liter'    => 'required|numeric|min:0',
        ]);

        $data['total'] = ($data['morning_quantity'] + $data['evening_quantity']) * $data['price_per_liter'];

        $milkSupplierDelivery->update($data);

        return redirect()->route('milk_supplier_deliveries.index')
                         ->with('success', 'تم تحديث التسليم بنجاح');
    }

    public function destroy(MilkSupplierDelivery $milkSupplierDelivery)
    {
        $milkSupplierDelivery->delete();

        return redirect()->route('milk_supplier_deliveries.index')
                         ->with('success', 'تم حذف التسليم بنجاح');
    }
}
