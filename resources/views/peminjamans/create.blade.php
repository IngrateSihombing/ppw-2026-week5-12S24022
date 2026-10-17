
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Peminjaman Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: #f4f7fb;
        }

        form {
            background: white;
            padding: 24px;
            border-radius: 10px;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input, select, button {
            box-sizing: border-box;
            width: 100%;
            padding: 10px;
            margin-top: 6px;
        }

        button {
            margin-top: 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .error {
            color: #dc2626;
        }

        .success {
            color: #15803d;
        }
    </style>
</head>
<body>
    <h1>Form Peminjaman Buku</h1>
    @if (session('last_borrower'))
    <div style="background: #dbeafe; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
        <strong>Peminjam Terakhir</strong>
        <p>NIM: {{ session('last_borrower.nim') }}</p>
        <p>Nama: {{ session('last_borrower.nama') }}</p>
        <p>Waktu: {{ session('last_borrower.waktu') }}</p>
    </div>
@endif

    @if (session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('peminjamans.store') }}" method="POST">
        @csrf

        <label for="buku_id">Pilih Buku</label>
        <select name="buku_id" id="buku_id" required>
            <option value="">-- Pilih buku --</option>
            @foreach ($bukus as $buku)
                <option value="{{ $buku->id }}"
                    {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                    {{ $buku->judul }} (Stok: {{ $buku->stok }})
                </option>
            @endforeach
        </select>

        <label for="nim_peminjam">NIM Peminjam</label>
        <input
            type="text"
            name="nim_peminjam"
            id="nim_peminjam"
            value="{{ old('nim_peminjam') }}"
            required
        >

        <label for="nama_peminjam">Nama Peminjam</label>
        <input
            type="text"
            name="nama_peminjam"
            id="nama_peminjam"
            value="{{ old('nama_peminjam') }}"
            required
        >

        <label for="tanggal_jatuh_tempo">Tanggal Jatuh Tempo</label>
        <input
            type="date"
            name="tanggal_jatuh_tempo"
            id="tanggal_jatuh_tempo"
            min="{{ date('Y-m-d') }}"
            value="{{ old('tanggal_jatuh_tempo') }}"
            required
        >

        <button type="submit">Simpan Peminjaman</button>
    </form>
</body>
</html>
