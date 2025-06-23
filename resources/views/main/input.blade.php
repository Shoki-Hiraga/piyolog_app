<form action="{{ route('input.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="logfile">ぴよログファイルを選択:</label>
    <input type="file" name="logfile" accept=".txt" required>
    <button type="submit">アップロード</button>
</form>
