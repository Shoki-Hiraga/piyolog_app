<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\BabyName;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $babyNameId = null;

        foreach ($lines as $line) {
            $line = trim($line);

            // ✅ 日付行（例: 2025/6/22(日)）
            if (preg_match('/^(\d{4}\/\d{1,2}\/\d{1,2})/', $line, $matches)) {
                $currentDate = date('Y-m-d', strtotime($matches[1]));
                continue;
            }

            // ✅ 名前行（例: そら (1か月10日)）
            if (preg_match('/^(.+?) \(\d+か月\d+日\)/u', $line, $matches)) {
                $babyName = $matches[1];

                // BabyNameを登録 or 取得
                $baby = BabyName::firstOrCreate(['name' => $babyName]);
                $babyNameId = $baby->id;

                continue;
            }

            // ✅ 活動行
            if (preg_match('/^(\d{2}:\d{2})\s+(.+)$/u', $line, $matches)) {
                $time = $matches[1];
                $rawContent = $matches[2];

                // 2スペース以上で分割 → コメント抽出
                $parts = preg_split('/\s{2,}/u', $rawContent, 2);
                $mainContent = trim($parts[0]);
                $textlog = isset($parts[1]) ? trim($parts[1]) : null;

                // ()補足 → textlogに追加
                preg_match_all('/\((.*?)\)/u', $mainContent, $parens);
                if (!empty($parens[1])) {
                    $textlog = trim(implode('、', $parens[1]) . ($textlog ? '、' . $textlog : ''));
                }

                // ()補足を削除して活動名に
                $content = preg_replace('/\s*\(.+?\)/u', '', $mainContent);

                $activity = null;
                $amount = null;
                $sleepMinutes = null;

                if (preg_match('/^(ミルク|搾母乳|搾乳)\s+(\d+ml)$/u', $content, $m)) {
                    $activity = $m[1];
                    $amount = $m[2];
                } elseif (preg_match('/^寝る$/u', $content)) {
                    $activity = '寝る';
                } elseif (preg_match('/^起きる\s*\((\d+)時間(\d+)分\)/u', $rawContent, $m)) {
                    $activity = '起きる';
                    $sleepMinutes = round((intval($m[1]) * 60 + intval($m[2])) / 10) * 10;
                } else {
                    $activity = $content;
                }

                // デバッグログ
                \Log::info('登録予定', [
                    'baby_name_id' => $babyNameId,
                    'date' => $currentDate,
                    'time' => $time,
                    'activity' => $activity,
                    'amount' => $amount,
                    'sleep_minutes' => $sleepMinutes,
                    'textlog' => $textlog,
                ]);

                // 安全チェック後に保存
                if ($babyNameId && $activity && $currentDate && $time) {
                    Log::create([
                        'baby_name_id' => $babyNameId,
                        'date' => $currentDate,
                        'time' => $time,
                        'activity' => $activity,
                        'amount' => $amount,
                        'sleep_minutes' => $sleepMinutes,
                        'textlog' => $textlog,
                    ]);
                }
            }
        }

        return redirect('/input')->with('success', 'ぴよログを取り込みました！');
    }
}
