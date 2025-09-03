<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    // عرض جميع الأعلاف
    public function index()
    {
        $feeds = Feed::all();
        return view('dashboardcomponents.feeds.index', compact('feeds'));
    }

    // إظهار نموذج إضافة علف جديد
    public function create()
    {
        return view('dashboardcomponents.feeds.create');
    }

    // تخزين علف جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ], [
            'name.required' => 'يرجى إدخال اسم العلف',
            'price.required' => 'يرجى إدخال سعر العلف',
            'price.numeric' => 'سعر العلف يجب أن يكون رقمًا',
            'price.min' => 'سعر العلف لا يمكن أن يكون سالبًا',
        ]);

        Feed::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->route('feeds.index')->with('success', 'تمت إضافة العلف بنجاح');
    }

    // إظهار نموذج تعديل علف
    public function edit(Feed $feed)
    {
        return view('dashboardcomponents.feeds.edit', compact('feed'));
    }

    // تحديث بيانات علف
    public function update(Request $request, Feed $feed)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ], [
            'name.required' => 'يرجى إدخال اسم العلف',
            'price.required' => 'يرجى إدخال سعر العلف',
            'price.numeric' => 'سعر العلف يجب أن يكون رقمًا',
            'price.min' => 'سعر العلف لا يمكن أن يكون سالبًا',
        ]);

        $feed->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()->route('feeds.index')->with('success', 'تم تحديث بيانات العلف بنجاح');
    }

    // حذف علف
    public function destroy(Feed $feed)
    {
        $feed->delete();
        return redirect()->route('feeds.index')->with('success', 'تم حذف العلف بنجاح');
    }
}
