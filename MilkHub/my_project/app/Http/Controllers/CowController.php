<?php

namespace App\Http\Controllers;

use App\Models\Cow;
use Illuminate\Http\Request;

class CowController extends Controller
{
    // عرض جميع الأبقار
    public function index()
    {
        $cows = Cow::all();
        return view('dashboardcomponents.cows.index', compact('cows'));
    }

    // إظهار نموذج إضافة بقرة جديدة
    public function create()
    {
        return view('dashboardcomponents.cows.create');
    }

    // تخزين بقرة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'morning_quantity' => 'required|numeric|min:0',
            'evening_quantity' => 'required|numeric|min:0',
        ], [
            'name.required' => 'يرجى إدخال اسم البقرة',
            'name.string' => 'اسم البقرة يجب أن يكون نصًا',
            'name.max' => 'اسم البقرة طويل جدًا',
            'morning_quantity.required' => 'يرجى إدخال كمية الإطعام الصباحية',
            'morning_quantity.numeric' => 'كمية الإطعام الصباحية يجب أن تكون رقمًا',
            'morning_quantity.min' => 'كمية الإطعام الصباحية لا يمكن أن تكون أقل من صفر',
            'evening_quantity.required' => 'يرجى إدخال كمية الإطعام المسائية',
            'evening_quantity.numeric' => 'كمية الإطعام المسائية يجب أن تكون رقمًا',
            'evening_quantity.min' => 'كمية الإطعام المسائية لا يمكن أن تكون أقل من صفر',
        ]);

        Cow::create([
            'name' => $request->name,
            'morning_quantity' => $request->morning_quantity,
            'evening_quantity' => $request->evening_quantity,
        ]);

        return redirect()->route('cows.index')->with('success', 'تمت إضافة البقرة بنجاح');
    }

    // إظهار نموذج تعديل بقرة
    public function edit(Cow $cow)
    {
        return view('dashboardcomponents.cows.edit', compact('cow'));
    }

    // تحديث بيانات بقرة
    public function update(Request $request, Cow $cow)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'morning_quantity' => 'required|numeric|min:0',
            'evening_quantity' => 'required|numeric|min:0',
        ], [
            'name.required' => 'يرجى إدخال اسم البقرة',
            'name.string' => 'اسم البقرة يجب أن يكون نصًا',
            'name.max' => 'اسم البقرة طويل جدًا',
            'morning_quantity.required' => 'يرجى إدخال كمية الإطعام الصباحية',
            'morning_quantity.numeric' => 'كمية الإطعام الصباحية يجب أن تكون رقمًا',
            'morning_quantity.min' => 'كمية الإطعام الصباحية لا يمكن أن تكون أقل من صفر',
            'evening_quantity.required' => 'يرجى إدخال كمية الإطعام المسائية',
            'evening_quantity.numeric' => 'كمية الإطعام المسائية يجب أن تكون رقمًا',
            'evening_quantity.min' => 'كمية الإطعام المسائية لا يمكن أن تكون أقل من صفر',
        ]);

        $cow->update([
            'name' => $request->name,
            'morning_quantity' => $request->morning_quantity,
            'evening_quantity' => $request->evening_quantity,
        ]);

        return redirect()->route('cows.index')->with('success', 'تم تحديث بيانات البقرة بنجاح');
    }

    // حذف بقرة
    public function destroy(Cow $cow)
    {
        $cow->delete();
        return redirect()->route('cows.index')->with('success', 'تم حذف البقرة بنجاح');
    }
}
