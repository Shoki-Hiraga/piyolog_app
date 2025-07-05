@php
    use App\Models\Log;
    use Carbon\Carbon;

    // 2025年5月第2週（日曜日）からスタート
    $cursor = Carbon::create(2025, 5, 11);

    // 最新ログの週末
    $latestLogDate = optional(Log::orderBy('date', 'desc')->first())->date ?? Carbon::now();
    $endMonth = Carbon::parse($latestLogDate)->endOfWeek();

    $weeks = collect();
    while ($cursor->lte($endMonth)) {
        $yearMonth = $cursor->format('Y年n月');
        $weekOfMonth = ceil($cursor->day / 7);
        $weeks->push([
            'label' => "{$yearMonth} 第{$weekOfMonth}週",
            'value' => $cursor->format('Y-m-d'),
        ]);
        $cursor->addWeek();
    }

    $defaultWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d');
@endphp

<form method="GET" action="{{ url()->current() }}">
    <label>開始週:
        <select name="start_week" id="start_week">
            @foreach ($weeks as $week)
                <option value="{{ $week['value'] }}" {{ request('start_week', $defaultWeek) === $week['value'] ? 'selected' : '' }}>
                    {{ $week['label'] }}
                </option>
            @endforeach
        </select>
    </label>

    <label>終了週:
        <select name="end_week" id="end_week">
            @foreach ($weeks as $week)
                <option value="{{ $week['value'] }}" {{ request('end_week', $defaultWeek) === $week['value'] ? 'selected' : '' }}>
                    {{ $week['label'] }}
                </option>
            @endforeach
        </select>
    </label>

    <button type="submit">絞り込む</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const start = document.getElementById('start_week');
        const end = document.getElementById('end_week');

        if (start && end) {
            start.addEventListener('change', function () {
                end.value = start.value;
            });
        }
    });
</script>
