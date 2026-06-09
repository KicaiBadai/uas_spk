@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h2 mb-1 text-primary fw-bold">
                <i class="bi bi-calculator me-2"></i> Hasil Perhitungan TOPSIS
            </h1>
            <p class="text-muted">Detail langkah-langkah perhitungan sistem pendukung keputusan metode TOPSIS</p>
        </div>
        
        <!-- Form Filter per Sekolah -->
        <div class="mt-3 mt-md-0">
            <form action="{{ route('topsis.detail') }}" method="GET" class="d-flex align-items-center gap-2">
                <label for="school_id" class="fw-semibold text-nowrap"><i class="bi bi-funnel"></i> Filter Sekolah:</label>
                <select name="school_id" id="school_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">-- Semua Sekolah --</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}" {{ $school_id == $school->id ? 'selected' : '' }}>
                            {{ $school->nama_sekolah }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    
    @if($selectedSchool)
        <div class="alert alert-info mb-4">
            <i class="bi bi-info-circle-fill me-2"></i> Menampilkan perhitungan TOPSIS khusus untuk pemain dari sekolah: <strong>{{ $selectedSchool->nama_sekolah }}</strong>
        </div>
    @else
        <div class="alert alert-secondary mb-4">
            <i class="bi bi-globe me-2"></i> Menampilkan perhitungan TOPSIS untuk <strong>Semua Pemain</strong> (Global). Pilih sekolah di atas untuk melihat detail per sekolah.
        </div>
    @endif

    <!-- 1. Matriks Keputusan -->
    <div class="card shadow-sm mb-4 border-0 rounded-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-semibold"><i class="bi bi-grid-3x3 me-2"></i> 1. Matriks Keputusan (X)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Alternatif</th>
                            @foreach($kriterias as $kriteria)
                                <th class="text-center">{{ $kriteria->nama_kriteria ?? $kriteria->nama }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alternatifs as $index => $alternatif)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $alternatif->nama_pemain ?? $alternatif->nama }}</td>
                            @foreach($kriterias as $k_index => $kriteria)
                                <td class="text-center">{{ isset($matrixKeputusan[$index][$k_index]) ? number_format($matrixKeputusan[$index][$k_index], 4) : '0.0000' }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 2. Matriks Pembagi -->
    @php
        $pembagi = [];
        foreach($kriterias as $k_index => $k) {
            $sum = 0;
            foreach($alternatifs as $index => $a) {
                $val = $matrixKeputusan[$index][$k_index] ?? 0;
                $sum += pow($val, 2);
            }
            $pembagi[$k_index] = sqrt($sum);
        }
    @endphp
    <div class="card shadow-sm mb-4 border-0 rounded-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-semibold"><i class="bi bi-slash-square me-2"></i> 2. Matriks Pembagi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            @foreach($kriterias as $kriteria)
                                <th class="text-center">{{ $kriteria->nama_kriteria ?? $kriteria->nama }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($kriterias as $k_index => $kriteria)
                                <td class="text-center fw-semibold text-primary">{{ number_format($pembagi[$k_index], 4) }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 3. Matriks Normalisasi -->
    <div class="card shadow-sm mb-4 border-0 rounded-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-semibold"><i class="bi bi-table me-2"></i> 3. Matriks Normalisasi (R)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Alternatif</th>
                            @foreach($kriterias as $kriteria)
                                <th class="text-center">{{ $kriteria->nama_kriteria ?? $kriteria->nama }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alternatifs as $index => $alternatif)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $alternatif->nama_pemain ?? $alternatif->nama }}</td>
                            @foreach($kriterias as $k_index => $kriteria)
                                <td class="text-center">{{ isset($matrixNormalisasi[$index][$k_index]) ? number_format($matrixNormalisasi[$index][$k_index], 4) : '0.0000' }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 4. Matriks Normalisasi Terbobot -->
    <div class="card shadow-sm mb-4 border-0 rounded-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-semibold"><i class="bi bi-bar-chart-steps me-2"></i> 4. Matriks Normalisasi Terbobot (Y)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Alternatif</th>
                            @foreach($kriterias as $kriteria)
                                <th class="text-center">{{ $kriteria->nama_kriteria ?? $kriteria->nama }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alternatifs as $index => $alternatif)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $alternatif->nama_pemain ?? $alternatif->nama }}</td>
                            @foreach($kriterias as $k_index => $kriteria)
                                 <td class="text-center">
                                        {{ isset($matrixTerbobot[$index][$k_index]) ? number_format($matrixTerbobot[$index][$k_index], 4) : '0.0000' }}
                                    </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 5. Solusi Ideal Positif (A+) dan Negatif (A-) -->
    <div class="card shadow-sm mb-4 border-0 rounded-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-semibold"><i class="bi bi-plus-slash-minus me-2"></i> 5. Solusi Ideal Positif (A+) dan Negatif (A-)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Solusi Ideal</th>
                            @foreach($kriterias as $kriteria)
                                <th class="text-center">{{ $kriteria->nama_kriteria ?? $kriteria->nama }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-semibold text-success"><i class="bi bi-plus-circle me-1"></i> Ideal Positif (A+)</td>
                            @foreach($kriterias as $k_index => $kriteria)
                                <td class="text-center text-success fw-bold">{{ isset($idealPositif[$k_index]) ? number_format($idealPositif[$k_index], 4) : '0.0000' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="fw-semibold text-danger"><i class="bi bi-dash-circle me-1"></i> Ideal Negatif (A-)</td>
                            @foreach($kriterias as $k_index => $kriteria)
                                <td class="text-center text-danger fw-bold">{{ isset($idealNegatif[$k_index]) ? number_format($idealNegatif[$k_index], 4) : '0.0000' }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 6. Nilai D+ dan D- -->
    <div class="card shadow-sm mb-4 border-0 rounded-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-semibold"><i class="bi bi-arrows-expand me-2"></i> 6. Jarak Solusi Ideal (D+ dan D-)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Alternatif</th>
                            <th class="text-center">D+ (Jarak Positif)</th>
                            <th class="text-center">D- (Jarak Negatif)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alternatifs as $index => $alternatif)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $alternatif->nama_pemain ?? $alternatif->nama }}</td>
                            <td class="text-center text-success">{{ isset($dPlus[$index]) ? number_format($dPlus[$index], 4) : '0.0000' }}</td>
                            <td class="text-center text-danger">{{ isset($dMinus[$index]) ? number_format($dMinus[$index], 4) : '0.0000' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 7. Nilai Preferensi (V) -->
    <div class="card shadow-sm mb-4 border-0 rounded-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-semibold"><i class="bi bi-check-circle me-2"></i> 7. Nilai Preferensi (V)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th>Alternatif</th>
                            <th class="text-center">Nilai Preferensi (V)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alternatifs as $index => $alternatif)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $alternatif->nama_pemain ?? $alternatif->nama }}</td>
                            <td class="text-center fw-bold text-primary">{{ isset($preferensi[$index]) ? number_format($preferensi[$index], 4) : '0.0000' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 8. Ranking Hasil Akhir -->
    <div class="card shadow-sm mb-4 border-0 rounded-4">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0 fw-semibold"><i class="bi bi-trophy me-2"></i> 8. Ranking Hasil Akhir</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" width="10%">Ranking</th>
                            <th>Alternatif</th>
                            <th class="text-center">Nilai Akhir (V)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ranking as $index => $rank)
                        <tr>
                            <td class="text-center">
                                @if($loop->iteration == 1)
                                    <span class="badge bg-warning text-dark px-3 py-2 fs-6"><i class="bi bi-star-fill me-1"></i> 1</span>
                                @elseif($loop->iteration == 2)
                                    <span class="badge bg-secondary px-3 py-2 fs-6"><i class="bi bi-award me-1"></i> 2</span>
                                @elseif($loop->iteration == 3)
                                    <span class="badge px-3 py-2 fs-6" style="background-color: #cd7f32;"><i class="bi bi-award me-1"></i> 3</span>
                                @else
                                    <span class="badge bg-light text-dark border px-3 py-2 fs-6">{{ $loop->iteration }}</span>
                                @endif
                            </td>
                            <td class="fw-semibold fs-5">{{ $rank['nama_pemain'] ?? $rank['nama'] }}</td>
                            <td class="text-center fw-bold fs-5 text-primary">{{ isset($rank['nilai']) ? number_format($rank['nilai'], 4) : '0.0000' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kesimpulan -->
    @if(count($ranking) > 0)
    <div class="alert alert-success border-0 shadow-sm rounded-4 p-4 d-flex align-items-center mb-5">
        <div class="me-4 d-none d-md-block">
            <i class="bi bi-trophy-fill text-warning" style="font-size: 4rem;"></i>
        </div>
        <div>
            <h3 class="alert-heading fw-bold mb-2">Kesimpulan</h3>
            <p class="mb-0 fs-5">
                Alternatif terbaik adalah <strong class="text-success text-uppercase">{{ $ranking[0]['nama_pemain'] ?? $ranking[0]['nama'] }}</strong> 
                dengan nilai <strong class="text-success">{{ number_format($ranking[0]['nilai'], 4) }}</strong>
            </p>
        </div>
    </div>
    @endif

</div>

<style>
    .card.shadow-sm {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card.shadow-sm:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
</style>
@endsection
