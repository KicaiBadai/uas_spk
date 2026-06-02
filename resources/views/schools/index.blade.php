@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Header halaman -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h2 mb-1">
                <i class="bi bi-building-fill text-primary me-2"></i> Data Sekolah
            </h1>
            <p class="text-muted">Kelola data sekolah yang memiliki tim futsal untuk penilaian TOPSIS</p>
        </div>
        <div class="mt-2 mt-sm-0">
            <a href="/schools/create" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Sekolah
            </a>
        </div>
    </div>

    {{-- Notifikasi flash message --}}
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

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabel Sekolah dengan desain modern -->
    <div class="table-responsive shadow-sm rounded-3">
        <table class="table table-bordered table-hover align-middle bg-white mb-0">
            <thead class="table-primary">
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th>Nama Sekolah</th>
                    <th width="15%" class="text-center">Jumlah Pemain</th>
                    <th width="20%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schools as $school)
                <tr>
                    <td class="text-center fw-semibold">{{ $loop->iteration }}</td>
                    <td>
                        <i class="bi bi-building me-2 text-primary"></i>
                        <span class="fw-semibold">{{ $school->nama_sekolah }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-info rounded-pill px-3 py-2">
                            <i class="bi bi-people-fill me-1"></i> 
                            {{ $school->players_count ?? $school->players->count() }} Pemain
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="/schools/{{ $school->id }}/edit" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="/schools/{{ $school->id }}" method="POST" class="d-inline-block" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus sekolah {{ $school->nama_sekolah }}? Semua pemain dari sekolah ini juga akan terhapus.');">
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
                    <td colspan="4" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Belum ada data sekolah. Silakan tambah sekolah baru.
                        <div class="mt-3">
                            <a href="/schools/create" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle"></i> Tambah Sekolah Sekarang
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Statistik ringkas -->
    @if($schools->count() > 0)
        <div class="d-flex justify-content-between align-items-center mt-3">
            <small class="text-muted">
                <i class="bi bi-database me-1"></i> Total {{ $schools->count() }} sekolah terdaftar
            </small>
            <small class="text-muted">
                <i class="bi bi-people me-1"></i> 
                Total pemain: {{ $schools->sum(function($school) { return $school->players->count(); }) }}
            </small>
        </div>
    @endif

    <!-- Pagination jika ada -->
    @if(method_exists($schools, 'links'))
        <div class="d-flex justify-content-end mt-4">
            {{ $schools->links() }}
        </div>
    @endif
</div>
@endsection