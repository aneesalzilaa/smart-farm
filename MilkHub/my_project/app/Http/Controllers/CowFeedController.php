<?php

namespace App\Http\Controllers;

use App\Models\Cow;
use App\Models\Feed;
use App\Models\CowFeed;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class CowFeedController extends Controller
{
    public function index()
    {
        $cowFeeds = CowFeed::with(['cow', 'feed'])->orderBy('date', 'desc')->get();
        $feeds = Feed::all(); // لجلب الأعلاف لاستخدامها في زر الإطعام الجماعي
        return view('dashboardcomponents.cowfeeds.index', compact('cowFeeds', 'feeds'));
    }

    public function create()
    {
        $cows = Cow::all();
        $feeds = Feed::all();
        return view('dashboardcomponents.cowfeeds.create', compact('cows', 'feeds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cow_id' => 'required|exists:cows,id',
            'feed_id' => 'required|exists:feeds,id',
            'period' => 'required|in:morning,evening',
            'quantity' => 'required|numeric|min:0.01',
            'date' => [
                'required',
                'date',
                Rule::unique('cow_feeds')->where(function ($query) use ($request) {
                    return $query->where('cow_id', $request->cow_id)
                                 ->where('feed_id', $request->feed_id)
                                 ->where('date', $request->date);
                }),
            ],
        ], [
            'date.unique' => 'تم إطعام هذه البقرة في نفس اليوم لهذا العلف، لا يمكن إضافة نفس السجل.',
        ]);

        $feed = Feed::findOrFail($request->feed_id);

        $morning = $request->period == 'morning' ? $request->quantity : 0;
        $evening = $request->period == 'evening' ? $request->quantity : 0;

        CowFeed::create([
            'cow_id' => $request->cow_id,
            'feed_id' => $request->feed_id,
            'date' => $request->date,
            'morning_quantity' => $morning,
            'evening_quantity' => $evening,
            'price' => $feed->price,
            'total_price' => ($morning + $evening) * $feed->price,
        ]);

        return redirect()->route('cowfeeds.index')->with('success', 'تم تسجيل الإطعام بنجاح');
    }

    public function edit(CowFeed $cowFeed)
    {
        $cows = Cow::all();
        $feeds = Feed::all();
        return view('dashboardcomponents.cowfeeds.edit', compact('cowFeed', 'cows', 'feeds'));
    }

    public function update(Request $request, CowFeed $cowFeed)
    {
        $request->validate([
            'cow_id' => 'required|exists:cows,id',
            'feed_id' => 'required|exists:feeds,id',
            'period' => 'required|in:morning,evening',
            'date' => 'required|date',
            'quantity' => 'nullable|numeric|min:0',
        ]);

        if ($request->period == 'morning') {
            $morning = $request->quantity;
            $evening = $cowFeed->evening_quantity;
        } elseif ($request->period == 'evening') {
            $morning = $cowFeed->morning_quantity;
            $evening = $request->quantity;
        }

        $cowFeed->update([
            'cow_id' => $request->cow_id,
            'feed_id' => $request->feed_id,
            'date' => $request->date,
            'morning_quantity' => $morning,
            'evening_quantity' => $evening,
            'total_quantity' => $morning + $evening,
            'price' => $cowFeed->feed->price,
            'total_price' => ($morning + $evening) * $cowFeed->feed->price,
        ]);

        return redirect()->route('cowfeeds.index')->with('success', 'تم تحديث بيانات الإطعام بنجاح');
    }

    public function destroy(CowFeed $cowFeed)
    {
        $cowFeed->delete();
        return redirect()->route('cowfeeds.index')->with('success', 'تم حذف السجل بنجاح');
    }

    public function daily(Request $request)
    {
        $query = CowFeed::with(['cow', 'feed']);

        if ($request->has('from_date') && $request->has('to_date')) {
            $query->whereBetween('date', [$request->from_date, $request->to_date]);
        } else {
            $today = \Carbon\Carbon::today();
            $query->whereDate('date', $today);
        }

        $cowFeeds = $query->get();

        return view('dashboardcomponents.cowfeeds.daily', compact('cowFeeds'));
    }

    // دالة إطعام جميع الأبقار بنفس العلف وبنفس التاريخ (اليوم)
  public function feedAllCows(Request $request)
{
    $request->validate([
        'feed_id' => 'required|exists:feeds,id',
    ]);

    $feed = Feed::findOrFail($request->feed_id);
    $cows = Cow::all();
    $today = now()->format('Y-m-d');

    foreach ($cows as $cow) {
        $existing = CowFeed::where('cow_id', $cow->id)
            ->where('feed_id', $feed->id)
            ->where('date', $today)
            ->first();

        if (!$existing) {
            CowFeed::create([
                'cow_id' => $cow->id,
                'feed_id' => $feed->id,
                'date' => $today,
                // جلب كمية الإطعام من جدول الأبقار
                'morning_quantity' => $cow->morning_quantity,
                'evening_quantity' => $cow->evening_quantity,
                'price' => $feed->price,
                'total_price' => ($cow->morning_quantity + $cow->evening_quantity) * $feed->price,
            ]);
        }
    }

    return redirect()->route('cowfeeds.index')->with('success', 'تم إطعام جميع الأبقار اليوم بنجاح.');
}

}
