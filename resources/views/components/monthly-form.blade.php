@php
    use App\Models\Log;
    use Carbon\Carbon;

    // 表示範囲: 2025年5月 〜 最終ログ月
    $startMonth = Carbon::create(2025, 5, 1);
    $latestLogDate = optional(Log::orderBy('date', 'desc')->first())->date ?? Carbon::now();
    $endMonth = Carbon::parse($latestLogDate)->startOfMonth();

    $months = collect();
    $cursor = $startMonth->copy();
    while ($cursor->lte($endMonth)) {
        $months->push([
            'label' => $cursor->format('Y年n月'),
            'value' => $cursor->format('Y-m'),
        ]);
        $cursor->addMonth();
    }

    $defaultMonth = Carbon::now()->format('Y-m');
@endphp

<form method="GET" action="{{ url()->current() }}">
    <label>開始月:
        <select name="start_month" id="start_month">
            @foreach ($months as $month)
                <option value="{{ $month['value'] }}" {{ request('start_month', $defaultMonth) === $month['value'] ? 'selected' : '' }}>
                    {{ $month['label'] }}
                </option>
            @endforeach
        </select>
    </label>

    <label>終了月:
        <select name="end_month" id="end_month">
            @foreach ($months as $month)
                <option value="{{ $month['value'] }}" {{ request('end_month', $defaultMonth) === $month['value'] ? 'selected' : '' }}>
                    {{ $month['label'] }}
                </option>
            @endforeach
        </select>
    </label>

    <button type="submit">絞り込む</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const start = document.getElementById('start_month');
        const end = document.getElementById('end_month');

        if (start && end) {
            start.addEventListener('change', function () {
                end.value = start.value;
            });
        }
    });
</script>
@
