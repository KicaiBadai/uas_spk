@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Header halaman -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h2 mb-1">
                <i class="bi bi-pencil-square text-primary me-2"></i> Penilaian Pemain
            </h1>
            <p class="text-muted">Input nilai untuk setiap pemain berdasarkan kriteria futsal (0–100)</p>
        </div>
        <div class="mt-2 mt-sm-0">
            <span class="badge bg-info fs-6 px-3 py-2">
                <i class="bi bi-info-circle me-1"></i> Metode TOPSIS
            </span>
        </div>
    </div>

    @if(count($schools) == 0)
        <div class="alert alert-warning text-center py-5">
            <i class="bi bi-building fs-1 d-block mb-3"></i>
            <h5>Belum Ada Data Sekolah</h5>
            <a href="/schools/create" class="btn btn-primary mt-2">Tambah Sekolah</a>
        </div>
    @elseif(count($criteria) == 0)
        <div class="alert alert-warning text-center py-5">
            <i class="bi bi-bar-chart-steps fs-1 d-block mb-3"></i>
            <h5>Belum Ada Data Kriteria</h5>
            <a href="/criteria/create" class="btn btn-primary mt-2">Tambah Kriteria</a>
        </div>
    @else
        <form action="/assessments" method="POST" id="assessmentForm">
            @csrf

            @foreach($schools as $school)
                @if($school->players->count() > 0)
                <div class="card shadow-sm mb-5 border-0 rounded-4 overflow-hidden">
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h4 class="mb-0">
                                <i class="bi bi-building me-2"></i>
                                {{ $school->nama_sekolah }}
                            </h4>
                            <span class="badge bg-light text-dark mt-2 mt-sm-0 px-3 py-2">
                                <i class="bi bi-people-fill me-1"></i> 
                                {{ $school->players->count() }} Pemain
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-dark sticky-top">
                                    <tr>
                                        <th style="min-width: 180px; position: sticky; left: 0; background-color: #212529; z-index: 20;">
                                            <i class="bi bi-person-circle me-1"></i> Nama Pemain
                                        </th>
                                        @foreach($criteria as $criterion)
                                            <th class="text-center" style="min-width: 120px;">
                                                {{ $criterion->nama_kriteria }}
                                                <span class="d-block small fw-normal text-muted">(0–100)</span>
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($school->players as $player)
                                    <tr>
                                        <td class="fw-semibold bg-light" style="position: sticky; left: 0; background-color: #f8f9fa; z-index: 10;">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-circle-small bg-primary text-white">
                                                    {{ strtoupper(substr($player->nama_pemain, 0, 2)) }}
                                                </div>
                                                {{ $player->nama_pemain }}
                                            </div>
                                        </td>
                                        @foreach($criteria as $criterion)
                                            @php
                                                $nilai = \App\Models\Assessment::where('player_id', $player->id)
                                                    ->where('criterion_id', $criterion->id)
                                                    ->value('nilai');
                                            @endphp
                                            <td class="text-center">
                                                <input type="number"
                                                       name="nilai[{{ $player->id }}][{{ $criterion->id }}]"
                                                       value="{{ old("nilai.{$player->id}.{$criterion->id}", $nilai) }}"
                                                       class="form-control form-control-sm text-center nilai-input"
                                                       min="0"
                                                       max="100"
                                                       step="1"
                                                       required
                                                       placeholder="0-100"
                                                       style="width: 100px; margin: 0 auto;">
                                            </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach

            <!-- Tombol aksi -->
            @if($schools->sum(fn($s) => $s->players->count()) > 0)
            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 pb-3 bg-white sticky-bottom">
                <a href="/players" class="btn btn-outline-secondary btn-lg px-4">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                    <i class="bi bi-save me-2"></i> Simpan Semua Penilaian
                </button>
            </div>
            @endif
        </form>
    @endif
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
    }
    
    .avatar-circle-small {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 12px;
        color: white;
        background-color: #0d6efd;
    }
    
    .nilai-input:focus {
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        border-color: #0d6efd;
    }
    
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.1) !important;
    }
    
    /* Sticky header kolom pertama */
    .table-responsive {
        overflow-x: auto;
    }
    
    .sticky-top th {
        top: 0;
        position: sticky;
    }
    
    .sticky-bottom {
        position: sticky;
        bottom: 0;
        z-index: 100;
        background: white;
        border-top: 1px solid #dee2e6;
    }
</style>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.nilai-input').forEach(input => {
        input.addEventListener('change', function() {
            let val = parseInt(this.value);
            if (isNaN(val)) {
                this.value = '';
            } else if (val > 100) {
                this.value = 100;
            } else if (val < 0) {
                this.value = 0;
            }
        });
        
        input.addEventListener('input', function() {
            let val = parseInt(this.value);
            if (!isNaN(val)) {
                if (val > 100) this.value = 100;
                if (val < 0) this.value = 0;
            }
        });
    });
    
    // Validasi sebelum submit
    const form = document.getElementById('assessmentForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            let isEmpty = false;
            document.querySelectorAll('.nilai-input').forEach(input => {
                if (input.value === '' || input.value === null) {
                    isEmpty = true;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            if (isEmpty) {
                e.preventDefault();
                alert('Harap isi semua nilai penilaian (0-100) sebelum menyimpan.');
            }
        });
    }
</script>
@endpush