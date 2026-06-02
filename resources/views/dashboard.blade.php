@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Dashboard -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h2 mb-1">
                <i class="bi bi-speedometer2 text-primary me-2"></i> Dashboard SPK TOPSIS
            </h1>
            <p class="text-muted">
                Sistem Pendukung Keputusan Seleksi Pemain Futsal Terbaik
                <br>
                <small class="text-secondary">Metode TOPSIS (Technique for Order Preference by Similarity to Ideal Solution)</small>
            </p>
        </div>
        <div class="mt-2 mt-sm-0">
            <span class="badge bg-success fs-6 px-3 py-2">
                <i class="bi bi-calendar-check me-1"></i> 
                {{ date('d F Y') }}
            </span>
        </div>
    </div>

    <!-- Kartu Statistik -->
    <div class="row g-4 mb-5">
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 bg-primary bg-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Sekolah</h6>
                            <h2 class="text-white mb-0">{{ number_format($jumlahSekolah) }}</h2>
                            <small class="text-white-50">Total Sekolah Terdaftar</small>
                        </div>
                        <i class="bi bi-building fs-1 text-white-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-white bg-opacity-10 border-0">
                    <a href="/schools" class="text-white text-decoration-none small">
                        Lihat Detail <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 bg-success bg-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Pemain</h6>
                            <h2 class="text-white mb-0">{{ number_format($jumlahPemain) }}</h2>
                            <small class="text-white-50">Total Pemain Terdaftar</small>
                        </div>
                        <i class="bi bi-people-fill fs-1 text-white-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-white bg-opacity-10 border-0">
                    <a href="/players" class="text-white text-decoration-none small">
                        Lihat Detail <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 bg-info bg-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Kriteria</h6>
                            <h2 class="text-white mb-0">{{ number_format($jumlahKriteria) }}</h2>
                            <small class="text-white-50">Kriteria Penilaian</small>
                        </div>
                        <i class="bi bi-bar-chart-steps fs-1 text-white-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-white bg-opacity-10 border-0">
                    <a href="/criteria" class="text-white text-decoration-none small">
                        Lihat Detail <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 bg-warning bg-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Penilaian</h6>
                            <h2 class="text-white mb-0">{{ number_format($jumlahPenilaian) }}</h2>
                            <small class="text-white-50">Data Penilaian Tersimpan</small>
                        </div>
                        <i class="bi bi-pencil-square fs-1 text-white-50"></i>
                    </div>
                </div>
                <div class="card-footer bg-white bg-opacity-10 border-0">
                    <a href="/assessments" class="text-white text-decoration-none small">
                        Lihat Detail <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Dua Kolom: Tentang Sistem & Alur -->
    <div class="row g-4">
        <!-- Tentang Sistem -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 pt-4">
                    <h4 class="mb-0">
                        <i class="bi bi-info-circle-fill text-primary me-2"></i>
                        Tentang Sistem
                    </h4>
                </div>
                <div class="card-body">
                    <p class="text-secondary">
                        Sistem Pendukung Keputusan Pemilihan Pemain Futsal Terbaik menggunakan metode 
                        <strong class="text-primary">TOPSIS</strong> (Technique for Order Preference by Similarity to Ideal Solution) 
                        untuk membantu menentukan pemain terbaik berdasarkan beberapa kriteria penilaian.
                    </p>
                    
                    <div class="mt-3 p-3 bg-light rounded-3">
                        <h6 class="fw-semibold mb-2">
                            <i class="bi bi-calculator-fill text-primary me-1"></i>
                            Metode TOPSIS
                        </h6>
                        <p class="small text-secondary mb-0">
                            TOPSIS bekerja berdasarkan konsep bahwa alternatif terbaik adalah yang memiliki 
                            jarak terpendek dari solusi ideal positif dan jarak terjauh dari solusi ideal negatif.
                        </p>
                    </div>
                    
                    <div class="mt-3">
                        <span class="badge bg-primary me-1">Benefit</span>
                        <span class="text-muted small">(semakin besar semakin baik)</span>
                        <span class="badge bg-warning text-dark ms-2 me-1">Cost</span>
                        <span class="text-muted small">(semakin kecil semakin baik)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alur Sistem -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 pt-4">
                    <h4 class="mb-0">
                        <i class="bi bi-diagram-3-fill text-success me-2"></i>
                        Alur Sistem
                    </h4>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @php
                            $steps = [
                                1 => ['Input Data Sekolah', 'building', 'primary', '/schools'],
                                2 => ['Input Data Pemain', 'people-fill', 'success', '/players'],
                                3 => ['Input Data Kriteria', 'bar-chart-steps', 'info', '/criteria'],
                                4 => ['Input Nilai Penilaian', 'pencil-square', 'warning', '/assessments'],
                                5 => ['Perhitungan TOPSIS', 'calculator-fill', 'danger', '/topsis'],
                                6 => ['Ranking Pemain Terbaik', 'trophy-fill', 'gold', '/topsis']
                            ];
                        @endphp
                        
                        @foreach($steps as $step => $data)
                            <div class="d-flex mb-3 align-items-start">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-{{ $data[2] }} bg-gradient text-white d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px;">
                                        <i class="bi bi-{{ $data[1] }} fs-5"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0 fw-semibold">
                                            <span class="badge bg-secondary me-2">{{ $step }}</span>
                                            {{ $data[0] }}
                                        </h6>
                                        <a href="{{ $data[3] }}" class="btn btn-sm btn-outline-primary mt-1 mt-sm-0">
                                            <i class="bi bi-arrow-right-circle"></i> Menu
                                        </a>
                                    </div>
                                    @if($step < 6)
                                        <div class="ms-4 mt-1">
                                            <i class="bi bi-arrow-down text-muted small"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action Footer -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-light border-0 shadow-sm">
                <div class="card-body text-center py-4">
                    <h5 class="mb-3">
                        <i class="bi bi-rocket-takeoff-fill text-primary me-2"></i>
                        Siap Menentukan Pemain Terbaik?
                    </h5>
                    <a href="/topsis" class="btn btn-primary btn-lg px-4 me-2">
                        <i class="bi bi-graph-up me-1"></i> Lihat Hasil TOPSIS
                    </a>
                    <a href="/assessments" class="btn btn-outline-primary btn-lg px-4">
                        <i class="bi bi-pencil-square me-1"></i> Input Penilaian
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Gaya khusus untuk kartu statistik */
    .card-footer a:hover {
        text-decoration: underline !important;
    }
    
    /* Warna khusus untuk gold */
    .bg-gold {
        background: linear-gradient(135deg, #f5af19 0%, #f12711 100%);
    }
    
    .text-gold {
        color: #f5af19;
    }
    
    /* Efek bayangan halus */
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection

@push('scripts')
<script>
    // Animasi angka statistik (count up)
    document.addEventListener('DOMContentLoaded', function() {
        const statValues = document.querySelectorAll('.card.bg-gradient .card-body h2');
        
        statValues.forEach(stat => {
            const target = parseInt(stat.innerText);
            if (isNaN(target)) return;
            
            let current = 0;
            const increment = Math.ceil(target / 30);
            const duration = 500;
            const stepTime = duration / (target / increment);
            
            const updateNumber = () => {
                current += increment;
                if (current >= target) {
                    stat.innerText = target.toLocaleString();
                    return;
                }
                stat.innerText = current.toLocaleString();
                setTimeout(updateNumber, stepTime);
            };
            
            // Mulai animasi
            updateNumber();
        });
    });
</script>
@endpush