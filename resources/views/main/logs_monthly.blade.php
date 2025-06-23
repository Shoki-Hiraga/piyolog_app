@extends('layouts.app')

@section('content')
    <h2>月別ログ一覧</h2>
    @foreach ($logs as $month => $group)
        <h3>{{ $month }}</h3>

        @php
            $totalAmount = $group->sum('amount');
        @endphp
        <p><strong>月合計量: {{ $totalAmount }}ml</strong></p>

        <table>
            <thead>
                <tr>
                    <th>日付</th><th>時刻</th><th>赤ちゃん</th><th>活動</th><th>量</th><th>睡眠（分）</th><th>補足</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($group->sortBy('date') as $log)
                    <tr>
                        <td>{{ $log->date }}</td>
                        <td>{{ $log->time }}</td>
                        <td>{{ $log->babyName->name }}</td>
                        <td>{{ $log->activity }}</td>
                        <td>{{ isset($log->amount) ? $log->amount . 'ml' : '-' }}</td>
                        <td>{{ $log->sleep_minutes ?? '-' }}</td>
                        <td>{{ $log->textlog ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
@endsection
