
<x-layout>
    <x-slot:title>Edit Kategori | SIPUS-Del</x-slot:title>

    <div class="mb-4">
        <h1>Edit Kategori</h1>
        <p class="text-muted">Perbarui informasi kategori buku.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('kategoris.update', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="kode_kategori" class="form-label">Kode Kategori</label>
                    <input
                        type="text"
                        name="kode_kategori"
                        id="kode_kategori"
                        class="form-control @error('kode_kategori') is-invalid @enderror"
                        value="{{ old('kode_kategori', $kategori->kode_kategori) }}"
                        required
                    >
                    @error('kode_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                    <input
                        type="text"
                        name="nama_kategori"
                        id="nama_kategori"
                        class="form-control @error('nama_kategori') is-invalid @enderror"
                        value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                        required
                    >
                    @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('kategoris.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layout>