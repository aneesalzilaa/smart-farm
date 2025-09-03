<?php

namespace App\Http\Controllers;

use App\Models\Pricing;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    // عرض جميع الأسعار
    public function index()
    {
        $pricings = Pricing::all();
        return view('dashboardcomponents.pricings.index', compact('pricings'));
    }

    // عرض نموذج إضافة سعر جديد
    public function create()
    {
        return view('dashboardcomponents.pricings.create');
    }

    // حفظ السعر الجديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        Pricing::create($request->all());

        return redirect()->route('pricings.index')->with('success', 'السعر تم إضافته بنجاح');
    }

    // عرض تفاصيل السعر
    public function show($id)
    {
        $pricing = Pricing::findOrFail($id);
        return view('dashboardcomponents.pricings.show', compact('pricing'));
    }

    // عرض نموذج تعديل السعر
    public function edit($id)
    {
        $pricing = Pricing::findOrFail($id);
        return view('dashboardcomponents.pricings.edit', compact('pricing'));
    }

    // تحديث السعر
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $pricing = Pricing::findOrFail($id);
        $pricing->update($request->all());

        return redirect()->route('pricings.index')->with('success', 'السعر تم تحديثه بنجاح');
    }

    // حذف السعر
    public function destroy($id)
    {
        $pricing = Pricing::findOrFail($id);
        $pricing->delete();

        return redirect()->route('pricings.index')->with('success', 'السعر تم حذفه بنجاح');
    }
}
