
<x-layout>
    <x-slot:title>Dashboard | SIPUS-Del</x-slot:title>

    <div class="mb-4">
        <h1>Dashboard Perpustakaan</h1>
        <p class="text-muted">
            Ringkasan statistik Sistem Informasi Perpustakaan Institut Teknologi Del
        </p>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Total Judul Buku</h6>
                    <h2>{{ $totalJudulBuku }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Total Stok Buku</h6>
                    <h2>{{ $totalStokBuku }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Sedang Dipinjam</h6>
                    <h2>{{ $sedangDipinjam }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Sudah Dikembalikan</h6>
                    <h2>{{ $sudahDikembalikan }}</h2>
                </div>
            </div>
        </div>
    </div>

    <
    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('bukus.index') }}" class="btn btn-primary">
            Lihat Katalog Buku
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger">
                Logout
            </button>
        </form>
    </div>

</x-layout>
