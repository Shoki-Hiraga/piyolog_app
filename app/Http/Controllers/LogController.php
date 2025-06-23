<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class LogController extends Controller
{
    public function daily()
    {
        $logs = Log::with('babyName')
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get()
            ->groupBy('date');

        return view('main.logs_daily', compact('logs'));
    }

    public function weekly()
    {
        $logs = Log::with('babyName')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->date)->startOfWeek()->format('Y-m-d');
            });

        return view('main.logs_weekly', compact('logs'));
    }

    public function monthly()
    {
        $logs = Log::with('babyName')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->date)->format('Y-m');
            });

        return view('main.logs_monthly', compact('logs'));
    }
}
