<form method="GET" action="{{ route('logs.index') }}">
    <label for="sort">ソート:</label>
    <select name="sort" id="sort" onchange="this.form.submit()">
        <option value="daily" {{ request('sort') == 'daily' ? 'selected' : '' }}>日毎</option>
        <option value="weekly" {{ request('sort') == 'weekly' ? 'selected' : '' }}>週毎</option>
        <option value="monthly" {{ request('sort') == 'monthly' ? 'selected' : '' }}>月毎</option>
    </select>
</form>
