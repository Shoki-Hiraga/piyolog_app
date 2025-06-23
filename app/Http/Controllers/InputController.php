<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Facades\Storage;

class InputController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'logfile' => 'required|file|mimes:txt',
        ]);

        $file = $request->file('logfile');
        $lines = file($file->getRealPath(), FILE_IGNORE_NEW_LINES);

        $currentDate = null;
        $babyName = null;

        foreach ($lines as $line) {
            $line = trim($line);

            // 日付行検出（例: 2025/5/17(土)）
            if (preg_match('/^(\d{4}\/\d{1,2}\/\d{1,2})/', $line, $matches)) {
                $currentDate = date('Y-m-d', strtotime($matches[1]));
                continue;
            }

            // 赤ちゃん名（例: そら (0か月6日)）
            if (preg_match('/^(.+?) \(\d+か月\d+日\)/', $line, $matches)) {
                $babyName = $matches[1];
                continue;
            }

            // 時刻 + 内容（例: 14:20 ミルク 50ml）
            if (preg_match('/^(\d{2}:\d{2})\s+(.+)$/', $line, $matches)) {
                $time = $matches[1];
                $raw = $matches[2];

                // 内容分割（「ミルク 50ml」「おしっこ」など）
                if (preg_match('/^(ミルク|搾母乳)\s+(\d+ml)$/', $raw, $activityMatches)) {
                    $activity = $activityMatches[1];
                    $amount = $activityMatches[2];
                } else {
                    $activity = $raw;
                    $amount = null;
                }

                Log::create([
                    'baby_name' => $babyName,
                    'date' => $currentDate,
                    'time' => $time,
                    'activity' => $activity,
                    'amount' => $amount,
                ]);
            }
        }

        return redirect('/input')->with('success', 'データを取り込みました！');
    }
}
