@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Header halaman -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h2 mb-1">
                <i class="bi bi-trophy-fill text-warning me-2"></i> Hasil TOPSIS
            </h1>
            <p class="text-muted">Ranking pemain terbaik per sekolah berdasarkan metode TOPSIS</p>
        </div>
        <div class="mt-2 mt-sm-0">
            <span class="badge bg-primary fs-6 px-3 py-2">
                <i class="bi bi-calculator-fill me-1"></i> Perhitungan TOPSIS
            </span>
        </div>
    </div>

    {{-- Notifikasi jika tidak ada data --}}
    @if(count($hasilPerSekolah) == 0)
        <div class="alert alert-warning text-center py-5" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-1 d-block mb-3"></i>
            <h4 class="alert-heading">Belum Ada Data Penilaian</h4>
            <p>Silakan lakukan penilaian pemain terlebih dahulu pada menu <strong>Penilaian</strong> untuk melihat hasil perankingan TOPSIS.</p>
            <hr>
            <a href="/assessments" class="btn btn-primary mt-2">
                <i class="bi bi-pencil-square me-1"></i> Ke Halaman Penilaian
            </a>
        </div>
    @else
        @foreach($hasilPerSekolah as $hasil)
        <div class="card shadow-sm mb-5 border-0 rounded-4 overflow-hidden">
            <!-- Header Sekolah dengan background gradien -->
            <div class="card-header bg-gradient-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h3 class="mb-0">
                        <i class="bi bi-building me-2"></i>
                        {{ $hasil['sekolah']->nama_sekolah }}
                    </h3>
                    <span class="badge bg-light text-dark mt-2 mt-sm-0 px-3 py-2">
                        <i class="bi bi-people-fill me-1"></i> 
                        {{ count($hasil['ranking']) }} Pemain
                    </span>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th width="10%" class="text-center">
                                    <i class="bi bi-trophy"></i> Ranking
                                </th>
                                <th>
                                    <i class="bi bi-person-circle"></i> Nama Pemain
                                </th>
                                <th width="30%" class="text-center">
                                    <i class="bi bi-graph-up"></i> Nilai TOPSIS
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hasil['ranking'] as $index => $item)
                            <tr>
                                <td class="text-center">
                                    @php
                                        $rank = $loop->iteration;
                                    @endphp
                                    @if($rank == 1)
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <i class="bi bi-star-fill text-warning fs-4"></i>
                                            <span class="fw-bold fs-5 text-warning">1</span>
                                            <span class="badge bg-warning text-dark ms-1">Juara 1</span>
                                        </div>
                                    @elseif($rank == 2)
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <i class="bi bi-star-fill text-secondary fs-4"></i>
                                            <span class="fw-bold fs-5 text-secondary">2</span>
                                            <span class="badge bg-secondary ms-1">Runner Up</span>
                                        </div>
                                    @elseif($rank == 3)
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <i class="bi bi-star-fill text-bronze fs-4"></i>
                                            <span class="fw-bold fs-5 text-bronze">3</span>
                                            <span class="badge bg-info ms-1">Peringkat 3</span>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center justify-content-center gap-1">
                                            <i class="bi bi-hash text-muted"></i>
                                            <span class="fw-bold fs-5 text-muted">{{ $rank }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-circle" style="background-color: {{ ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1'][array_rand(['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1']) ] }}">
                                            {{ strtoupper(substr($item['nama_pemain'], 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="fw-semibold fs-5">{{ $item['nama_pemain'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="fs-3 fw-bold text-primary">{{ number_format($item['nilai'], 4) }}</span>
                                        <div class="progress w-75 mt-2" style="height: 8px;">
                                            <div class="progress-bar bg-success" 
                                                 role="progressbar" 
                                                 style="width: {{ $item['nilai'] * 100 }}%" 
                                                 aria-valuenow="{{ $item['nilai'] * 100 }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small class="text-muted mt-1">{{ round($item['nilai'] * 100, 2) }}%</small>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Informasi Pemain Terbaik -->
                @if(count($hasil['ranking']) > 0)
                <div class="alert alert-success m-3 rounded-3">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <i class="bi bi-trophy-fill fs-1 text-warning"></i>
                        <div>
                            <strong class="fs-5">Pemain Terbaik Sekolah {{ $hasil['sekolah']->nama_sekolah }}:</strong>
                            <span class="fw-bold text-success">{{ $hasil['ranking'][0]['nama_pemain'] }}</span>
                            <br>
                            <small>Nilai TOPSIS: {{ number_format($hasil['ranking'][0]['nilai'], 4) }} ({{ round($hasil['ranking'][0]['nilai'] * 100, 2) }}%)</small>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach

        <!-- Ringkasan Global -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card bg-light border-0 shadow-sm">
                    <div class="card-body text-center py-4">
                        <h5 class="mb-3">
                            <i class="bi bi-bar-chart-steps text-primary me-2"></i>
                            Ringkasan Perankingan TOPSIS
                        </h5>
                        <p class="text-muted mb-0">
                            Menampilkan ranking pemain terbaik per sekolah berdasarkan perhitungan metode TOPSIS.
                            Nilai mendekati 1 menunjukkan performa yang lebih baik.
                        </p>
                        <hr class="my-3">
                        <div class="d-flex justify-content-center gap-4 flex-wrap">
                            <div><i class="bi bi-star-fill text-warning"></i> <span class="text-muted">Juara 1 Sekolah</span></div>
                            <div><i class="bi bi-star-fill text-secondary"></i> <span class="text-muted">Runner Up</span></div>
                            <div><i class="bi bi-star-fill text-bronze"></i> <span class="text-muted">Peringkat 3</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    /* Gradient header untuk kartu sekolah */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #1e3c72 0%, #2b4c7c 100%);
    }
    
    /* Style untuk avatar lingkaran */
    .avatar-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 16px;
        color: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    
    /* Warna bronze khusus untuk peringkat 3 */
    .text-bronze {
        color: #cd7f32;
    }
    
    /* Efek hover pada baris tabel */
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
        transition: background-color 0.2s ease;
    }
    
    /* Animasi progress bar */
    .progress-bar {
        transition: width 0.8s ease;
    }
    
    /* Card hover effect */
    .card.shadow-sm {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card.shadow-sm:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.12) !important;
    }
</style>
@endsection

@push('scripts')
<script>
    // Animasi progress bar saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 150);
        });
    });
</script>
@endpush