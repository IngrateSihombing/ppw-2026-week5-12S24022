<x-layout>
    <x-slot:title>Tambah Kategori</x-slot:title>

    <h1 class="mb-4">Tambah Kategori</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kategoris.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="kode_kategori" class="form-label">
                Kode Kategori
            </label>

            <input
                type="text"
                name="kode_kategori"
                id="kode_kategori"
                class="form-control"
                value="{{ old('kode_kategori') }}"
                required
            >
        </div>

        <div class="mb-3">
            <label for="nama_kategori" class="form-label">
                Nama Kategori
            </label>

            <input
                type="text"
                name="nama_kategori"
                id="nama_kategori"
                class="form-control"
                value="{{ old('nama_kategori') }}"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary">
            Simpan
        </button>

        <a href="{{ route('kategoris.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </form>
</x-layout>