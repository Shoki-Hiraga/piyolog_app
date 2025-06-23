<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
    public function index()
    {
        $logs = Log::with('babyName')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        return view('main.logs', compact('logs'));
    }
}
