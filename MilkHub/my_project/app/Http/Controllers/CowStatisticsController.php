<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MilkProduction;
use App\Models\CowFeed;  // هذا مهم
use App\Models\Cow;
use Carbon\Carbon;

class CowStatisticsController extends Controller
{
    public function showStatistics(Request $request)
    {
        $cowId = $request->cow_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $query = MilkProduction::query();

        if ($cowId && $cowId !== 'all') {
            $query->where('cow_id', $cowId);
        }

        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        $productions = $query->get();

        $statistics = [];

        foreach ($productions as $prod) {
            $date = $prod->date->toDateString();
            $cow_id = $prod->cow_id;
            $feed = CowFeed::where('cow_id', $cow_id)->whereDate('date', $date)->first();

            $statistics[] = [
                'date' => $date,
                'cow_id' => $cow_id,
                'cow_name' => $prod->cow->name ?? '',
                'production' => $prod,
                'feed' => $feed,
            ];
        }

        $cows = Cow::all();
        $cowName = $cowId !== 'all' && $cowId ? Cow::find($cowId)?->name : null;

        return view('dashboardcomponents.cow_statistics', compact('statistics', 'cows', 'cowId', 'cowName'));
    }
}
