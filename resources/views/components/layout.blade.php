<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'SIPUS-Del' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <nav style="background-color: #4C1D95; padding: 15px;">
        <a href="{{ route('bukus.index') }}" style="color: white; margin-right: 20px;">
            Daftar Buku
        </a>

        <a href="{{ route('kategoris.index') }}" style="color: white;">
            Kategori
        </a>
    </nav>

    <main class="container mt-4">
        {{ $slot }}
    </main>
</body>
</html>