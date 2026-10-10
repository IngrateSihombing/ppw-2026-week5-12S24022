
<x-layout>
    <x-slot:title>Edit Buku | SIPUS-Del</x-slot:title>

    <div class="mb-4">
        <h1>Edit Buku</h1>
        <p class="text-muted">Perbarui informasi buku perpustakaan.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('bukus.update', $buku->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" name="isbn" id="isbn"
                        class="form-control @error('isbn') is-invalid @enderror"
                        value="{{ old('isbn', $buku->isbn) }}" required>
                    @error('isbn')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Buku</label>
                    <input type="text" name="judul" id="judul"
                        class="form-control @error('judul') is-invalid @enderror"
                        value="{{ old('judul', $buku->judul) }}" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="penulis" class="form-label">Penulis</label>
                    <input type="text" name="penulis" id="penulis"
                        class="form-control"
                        value="{{ old('penulis', $buku->penulis) }}" required>
                </div>

                <div class="mb-3">
                    <label for="penerbit" class="form-label">Penerbit</label>
                    <input type="text" name="penerbit" id="penerbit"
                        class="form-control"
                        value="{{ old('penerbit', $buku->penerbit) }}" required>
                </div>

                <div class="mb-3">
                    <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" id="tahun_terbit"
                        class="form-control"
                        value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                        min="1901" max="2155" required>
                </div>

                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select name="kategori_id" id="kategori_id"
                        class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}"
                                @selected(old('kategori_id', $buku->kategori_id) == $kategori->id)>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" id="stok"
                        class="form-control"
                        value="{{ old('stok', $buku->stok) }}"
                        min="0" required>
                </div>

                <div class="mb-3">
                    <label for="sinopsis" class="form-label">Sinopsis</label>
                    <textarea name="sinopsis" id="sinopsis"
                        class="form-control" rows="4">{{ old('sinopsis', $buku->sinopsis) }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('bukus.index') }}"
                        class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-layout>