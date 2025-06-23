@extends('layouts.app')

@section('content')
@include('components.sort-form')一覧
    <h2>@include('components.sitename')一覧</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>日付</th>
                <th>時刻</th>
                <th>赤ちゃん</th>
                <th>活動</th>
                <th>量</th>
                <th>睡眠（分）</th>
                <th>補足</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr>
                    <td>{{ $log->date }}</td>
                    <td>{{ $log->time }}</td>
                    <td>{{ $log->babyName->name }}</td>
                    <td>{{ $log->activity }}</td>
                    <td>{{ isset($log->amount) ? $log->amount . 'ml' : '-' }}</td>
                    <td>{{ $log->sleep_minutes ?? '-' }}</td>
                    <td>{{ $log->textlog ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">データがありません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
