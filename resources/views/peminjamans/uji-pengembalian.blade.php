
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Uji Pengembalian Buku</title>
</head>
<body>
    <h1>Uji Pengembalian Buku</h1>

    <p>Kode pinjam: {{ $peminjaman->kode_pinjam }}</p>
    <p>NIM: {{ $peminjaman->nim_peminjam }}</p>
    <p>Status: {{ $peminjaman->status }}</p>

    <form action="{{ route('peminjamans.kembalikan', $peminjaman) }}"
          method="POST">
        @csrf
        <button type="submit">Kembalikan Buku</button>
    </form>
</body>
</html>
