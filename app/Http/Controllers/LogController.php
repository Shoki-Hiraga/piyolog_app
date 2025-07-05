<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class LogController extends Controller
{
    public function daily(Request $request)
    {
        $query = Log::with('babyName');

        $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date) : Carbon::today();
        $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date) : Carbon::today();

        $query->whereBetween('date', [$startDate, $endDate]);

        $logs = $query->orderBy('date', 'asc')
                    ->orderBy('time', 'asc')
                    ->get()
                    ->groupBy('date');

        return view('main.logs_daily', compact('logs'));
    }


    public function weekly(Request $request)
    {
        $query = Log::with('babyName');

        if ($request->filled('start_week') && $request->filled('end_week')) {
            $startDate = Carbon::parse($request->start_week); // 選択された週の開始日
            $endDate = Carbon::parse($request->end_week)->addDays(6); // その週の終了日

            $query->whereBetween('date', [$startDate, $endDate]);
        }

        $logs = $query->orderBy('date', 'asc')
                    ->orderBy('time', 'asc')
                    ->get()
                    ->groupBy(function ($log) {
                        return Carbon::parse($log->date)->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
                    });

        return view('main.logs_weekly', compact('logs'));
    }


    public function monthly(Request $request)
    {
        $query = Log::with('babyName');

        if ($request->filled('start_month') && $request->filled('end_month')) {
            $startDate = Carbon::parse($request->start_month)->startOfMonth();
            $endDate = Carbon::parse($request->end_month)->endOfMonth();

            $query->whereBetween('date', [$startDate, $endDate]);
        }

        $logs = $query->orderBy('date', 'asc')
                    ->orderBy('time', 'asc')
                    ->get()
                    ->groupBy(function ($log) {
                        return Carbon::parse($log->date)->format('Y-m');
                    });

        return view('main.logs_monthly', compact('logs'));
    }
}
