
<x-layout>
    <x-slot:title>Daftar Buku | SIPUS-Del</x-slot:title>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1">Daftar Buku</h1>
            <p class="text-muted mb-0">
                Sistem Informasi Perpustakaan Institut Teknologi Del
            </p>
        </div>

        <a href="{{ route('bukus.create') }}" class="btn btn-primary">
            + Tambah Buku
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        
<div class="card-body">
    <form action="{{ route('bukus.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Cari judul, penulis, ISBN, atau kategori..."
                value="{{ request('search') }}">

            <button type="submit" class="btn btn-primary">
                Cari
            </button>

            @if (request('search'))
                <a href="{{ route('bukus.index') }}" class="btn btn-outline-secondary">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <div class="table-responsive">

                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Judul Buku</th>
                            <th>ISBN</th>
                            <th>Kategori</th>
                            <th>Tahun Terbit</th>
                            <th>Stok</th>
<th>Jumlah Peminjaman</th>
<th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($bukus as $buku)
                            <tr>
                                <td>{{ $bukus->firstItem() + $loop->index }}</td>

                                <td>
                                    <strong>{{ $buku->judul }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ $buku->penulis }}
                                    </small>
                                </td>

                                <td>{{ $buku->isbn }}</td>
                                <td>{{ $buku->kategori->nama_kategori }}</td>
                                <td>{{ $buku->tahun_terbit }}</td>
                                <td>{{ $buku->stok }}</td>
                                <td>{{ $buku->peminjamans_count }}</td>

                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailBuku{{ $buku->id }}">
                                        Detail
                                    </button>

                                    <a
                                        href="{{ route('bukus.edit', $buku->id) }}"
                                        class="btn btn-sm btn-outline-warning">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('bukus.destroy', $buku->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    Belum ada data buku.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $bukus->links() }}
            </div>
        </div>
    </div>

    @foreach ($bukus as $buku)
        <div
            class="modal fade"
            id="detailBuku{{ $buku->id }}"
            tabindex="-1"
            aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div
                        class="modal-header"
                        style="background-color: #4C1D95; color: white;">

                        <h5 class="modal-title">Detail Buku</h5>

                        <button
                            type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"
                            aria-label="Tutup">
                        </button>
                    </div>

                    <div class="modal-body">
                        <h5>{{ $buku->judul }}</h5>
                        <hr>

                        <p><strong>ISBN:</strong> {{ $buku->isbn }}</p>
                        <p><strong>Penulis:</strong> {{ $buku->penulis }}</p>
                        <p><strong>Penerbit:</strong> {{ $buku->penerbit }}</p>
                        <p><strong>Kategori:</strong> {{ $buku->kategori->nama_kategori }}</p>
                        <p><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
                        <p><strong>Stok:</strong> {{ $buku->stok }}</p>

                        <p class="mb-1"><strong>Sinopsis:</strong></p>
                        <p>{{ $buku->sinopsis ?: 'Belum ada sinopsis.' }}</p>
                    </div>

                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-layout>