<form method="GET" action="{{ url()->current() }}">
    <label>開始日付: 
        <input type="date" name="start_date" value="{{ request('start_date', \Carbon\Carbon::today()->format('Y-m-d')) }}">
    </label>
    <label>終了日付: 
        <input type="date" name="end_date" value="{{ request('end_date', \Carbon\Carbon::today()->format('Y-m-d')) }}">
    </label>
    <button type="submit">絞り込む</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startInput = document.querySelector('input[name="start_date"]');
        const endInput = document.querySelector('input[name="end_date"]');

        if (startInput && endInput) {
            startInput.addEventListener('change', function () {
                endInput.value = startInput.value;
            });
        }
    });
</script>
