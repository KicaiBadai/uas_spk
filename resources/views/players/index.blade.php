@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Header halaman -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h2 mb-1">
                <i class="bi bi-people-fill text-primary me-2"></i> Data Pemain
            </h1>
            <p class="text-muted">Kelola data pemain futsal yang akan dinilai dengan metode TOPSIS</p>
        </div>
        <div class="mt-2 mt-sm-0">
            <a href="/players/create" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Pemain
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

    <!-- Tabel Pemain dengan desain modern -->
    <div class="table-responsive shadow-sm rounded-3">
        <table class="table table-bordered table-hover align-middle bg-white mb-0">
            <thead class="table-primary">
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="25%">Sekolah</th>
                    <th width="25%">Nama Pemain</th>
                    <th width="20%">Posisi</th>
                    <th width="25%" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($players as $player)
                <tr>
                    <td class="text-center fw-semibold">{{ $loop->iteration }}</td>
                    <td>
                        <i class="bi bi-building me-1 text-secondary"></i>
                        {{ $player->school->nama_sekolah ?? 'Tidak ada sekolah' }}
                    </td>
                    <td>
                        <i class="bi bi-person-circle me-1 text-primary"></i>
                        <span class="fw-semibold">{{ $player->nama_pemain }}</span>
                    </td>
                    <td>
                        @php
                            $posisiBadge = [
                                'Goalkeeper' => 'danger',
                                'Defender' => 'info',
                                'Midfielder' => 'warning',
                                'Forward' => 'success'
                            ];
                            $badgeColor = $posisiBadge[$player->posisi] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $badgeColor }} px-3 py-2">
                            <i class="bi bi-person-badge me-1"></i> {{ $player->posisi }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="/players/{{ $player->id }}/edit" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="/players/{{ $player->id }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemain {{ $player->nama_pemain }}? Data penilaian terkait juga akan terhapus.');">
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
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Belum ada data pemain. Silakan tambah pemain baru.
                        <div class="mt-3">
                            <a href="/players/create" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle"></i> Tambah Pemain Sekarang
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Statistik ringkas -->
    @if($players->count() > 0)
        <div class="d-flex justify-content-between align-items-center mt-3">
            <small class="text-muted">
                <i class="bi bi-database me-1"></i> Total {{ $players->count() }} pemain terdaftar
            </small>
        </div>
    @endif

    <!-- Pagination jika ada -->
    @if(method_exists($players, 'links'))
        <div class="d-flex justify-content-end mt-4">
            {{ $players->links() }}
        </div>
    @endif
</div>
@endsection