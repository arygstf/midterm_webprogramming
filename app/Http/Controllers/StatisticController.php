<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        // Which month is selected, e.g. "2026-10". Defaults to the current month.
        $month = $request->query('month', now()->format('Y-m'));
        $start = Carbon::createFromFormat('Y-m-d', $month . '-01')->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $done = $request->user()->tasks()
            ->whereBetween('completed_at', [$start, $end])
            ->get();

        // Count completed tasks in the four ranges from your design
        $buckets = ['1-7' => 0, '8-14' => 0, '15-22' => 0, '23-31' => 0];

        foreach ($done as $task) {
            $day = $task->completed_at->day;
            $key = $day <= 7 ? '1-7' : ($day <= 14 ? '8-14' : ($day <= 22 ? '15-22' : '23-31'));
            $buckets[$key]++;
        }

        $max = max(1, max($buckets));
        $total = $done->count();

        // The last 4 months, for the tabs at the top
        $months = collect(range(3, 0))->map(fn ($i) => now()->startOfMonth()->subMonths($i));

        return view('statistics', compact('buckets', 'max', 'total', 'month', 'months'));
    }
}