
<x-layout>
    <x-slot:title>Daftar Kategori | SIPUS-Del</x-slot:title>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>Daftar Kategori</h1>
            <p class="text-muted mb-0">
                Kategori buku perpustakaan Institut Teknologi Del
            </p>
        </div>

        <a href="{{ route('kategoris.create') }}" class="btn btn-primary">
            + Tambah Kategori
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

    @forelse ($kategoris as $kategori)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">
                            {{ $kategori->nama_kategori }}
                        </h5>

                        <p class="mb-1">
                            <strong>Kode:</strong>
                            {{ $kategori->kode_kategori }}
                        </p>

                        <p class="mb-0">
                            <strong>Jumlah Buku:</strong>
                            {{ $kategori->bukus->count() }}
                        </p>
                    </div>

                    <div class="d-flex gap-2">
                        <a
                            href="{{ route('kategoris.edit', $kategori->id) }}"
                            class="btn btn-sm btn-outline-warning">
                            Edit
                        </a>

                        <form
                            action="{{ route('kategoris.destroy', $kategori->id) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-sm btn-outline-danger">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            Belum ada data kategori.
        </div>
    @endforelse

    <div class="mt-4">
        {{ $kategoris->links() }}
    </div>
</x-layout>