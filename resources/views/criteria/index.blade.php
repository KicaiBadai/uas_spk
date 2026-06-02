@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Header halaman -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h2 mb-1">
                <i class="bi bi-table text-primary me-2"></i> Data Kriteria
            </h1>
            <p class="text-muted">Kelola kriteria yang digunakan dalam perhitungan TOPSIS (bobot, tipe benefit/cost)</p>
        </div>
        <div class="mt-2 mt-sm-0">
            <a href="/criteria/create" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Kriteria
            </a>
        </div>
    </div>

    {{-- Notifikasi flash message (opsional, jika ada session success) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabel Kriteria dengan desain modern -->
    <div class="table-responsive shadow-sm rounded-3">
        <table class="table table-bordered table-hover align-middle bg-white mb-0">
            <thead class="table-primary">
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="15%">Kode</th>
                    <th>Nama Kriteria</th>
                    <th width="12%" class="text-center">Bobot</th>
                    <th width="15%" class="text-center">Tipe</th>
                    <th width="15%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($criteria as $c)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td><span class="badge bg-secondary">{{ $c->kode }}</span></td>
                    <td class="fw-semibold">{{ $c->nama_kriteria }}</td>
                    <td class="text-center">{{ $c->bobot }}</td>
                    <td class="text-center">
                        @if($c->tipe == 'benefit')
                            <span class="badge bg-success"><i class="bi bi-arrow-up-circle me-1"></i> Benefit</span>
                        @else
                            <span class="badge bg-warning text-dark"><i class="bi bi-arrow-down-circle me-1"></i> Cost</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="/criteria/{{ $c->id }}/edit" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="/criteria/{{ $c->id }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kriteria {{ $c->nama_kriteria }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Belum ada data kriteria. Silakan tambah kriteria baru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Jika perlu pagination, tambahkan di sini -->
    @if(method_exists($criteria, 'links'))
        <div class="d-flex justify-content-end mt-4">
            {{ $criteria->links() }}
        </div>
    @endif
</div>
@endsection