<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // عرض قائمة العملاء
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('dashboardcomponents.customers.index', compact('customers'));
    }

    // عرض نموذج الإضافة
    public function create()
    {
        return view('dashboardcomponents.customers.create');
    }

    // حفظ العميل الجديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:customers,phone',
            'password' => 'required|min:4',
        ], [
            'name.required' => 'الاسم مطلوب',
            'name.string' => 'الاسم يجب أن يكون نصًا',
            'name.max' => 'الاسم يجب ألا يتجاوز 255 حرفًا',
            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.unique' => 'رقم الهاتف مستخدم مسبقًا',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'كلمة المرور يجب أن تكون على الأقل 4 أحرف',
        ]);

        Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => $request->password, // غير مشفّرة حسب طلبك
        ]);

        return redirect()->route('customers.index')->with('success', 'تمت إضافة العميل بنجاح');
    }

    // عرض نموذج التعديل
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('dashboardcomponents.customers.edit', compact('customer'));
    }

    // تحديث بيانات العميل
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:customers,phone,' . $customer->id,
            'password' => 'required|min:4',
        ], [
            'name.required' => 'الاسم مطلوب',
            'name.string' => 'الاسم يجب أن يكون نصًا',
            'name.max' => 'الاسم يجب ألا يتجاوز 255 حرفًا',
            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.unique' => 'رقم الهاتف مستخدم مسبقًا',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'كلمة المرور يجب أن تكون على الأقل 4 أحرف',
        ]);

        $customer->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => $request->password,
        ]);

        return redirect()->route('customers.index')->with('success', 'تم تعديل بيانات العميل');
    }

    // حذف عميل
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->back()->with('success', 'تم حذف العميل بنجاح');
    }
}
