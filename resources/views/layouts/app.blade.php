<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'そらぴよログ')</title>

@include('components.noindex')
@include('components.header')
</head>
<body>

    <header>
        <h1>そらぴよログ管理</h1>
        @include('components.navi')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        &copy; {{ date('Y') }} ぴよログLaravelApp
    </footer>

</body>
</html>
