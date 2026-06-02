@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Header halaman -->
    <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
        <a href="/players" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <div>
            <h1 class="h2 mb-0">
                <i class="bi bi-pencil-square text-warning me-2"></i> Edit Pemain
            </h1>
            <p class="text-muted mt-1">Ubah informasi data pemain futsal</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <form action="/players/{{ $player->id }}" method="POST" id="editForm">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- Sekolah -->
                    <div class="col-md-12">
                        <label for="school_id" class="form-label fw-semibold">
                            <i class="bi bi-building me-1"></i> Sekolah <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-lg @error('school_id') is-invalid @enderror" 
                                id="school_id" 
                                name="school_id" 
                                required>
                            <option value="">-- Pilih Sekolah --</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}" 
                                    {{ old('school_id', $player->school_id) == $school->id ? 'selected' : '' }}>
                                    <i class="bi bi-building"></i> {{ $school->nama_sekolah }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Pilih asal sekolah pemain.</div>
                        @error('school_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Pemain -->
                    <div class="col-md-6">
                        <label for="nama_pemain" class="form-label fw-semibold">
                            <i class="bi bi-person-badge me-1"></i> Nama Pemain <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control form-control-lg @error('nama_pemain') is-invalid @enderror"
                               id="nama_pemain"
                               name="nama_pemain"
                               value="{{ old('nama_pemain', $player->nama_pemain) }}"
                               placeholder="Contoh: Muhammad Rizki, Ahmad Fauzan"
                               required>
                        <div class="form-text">Nama lengkap pemain futsal.</div>
                        @error('nama_pemain')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Posisi -->
                    <div class="col-md-6">
                        <label for="posisi" class="form-label fw-semibold">
                            <i class="bi bi-person-arms-up me-1"></i> Posisi <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-lg @error('posisi') is-invalid @enderror" 
                                id="posisi" 
                                name="posisi" 
                                required>
                            <option value="">-- Pilih Posisi --</option>
                            <option value="Goalkeeper" {{ old('posisi', $player->posisi) == 'Goalkeeper' ? 'selected' : '' }}>
                                🧤 Goalkeeper (Penjaga Gawang)
                            </option>
                            <option value="Defender" {{ old('posisi', $player->posisi) == 'Defender' ? 'selected' : '' }}>
                                🛡️ Defender (Pemain Bertahan)
                            </option>
                            <option value="Midfielder" {{ old('posisi', $player->posisi) == 'Midfielder' ? 'selected' : '' }}>
                                ⚡ Midfielder (Gelandang)
                            </option>
                            <option value="Forward" {{ old('posisi', $player->posisi) == 'Forward' ? 'selected' : '' }}>
                                🎯 Forward (Penyerang)
                            </option>
                        </select>
                        <div class="form-text">
                            <span class="badge bg-danger">Goalkeeper</span>
                            <span class="badge bg-info">Defender</span>
                            <span class="badge bg-warning">Midfielder</span>
                            <span class="badge bg-success">Forward</span>
                        </div>
                        @error('posisi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Informasi tambahan -->
                <div class="alert alert-warning mt-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Perhatian:</strong> Mengubah data pemain tidak akan mempengaruhi penilaian yang sudah ada, namun pastikan data yang dimasukkan sudah benar.
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between mt-4 pt-3">
                    <a href="/players" class="btn btn-outline-secondary btn-lg px-4">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                        <i class="bi bi-check-circle me-2"></i> Perbarui Pemain
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Validasi tambahan untuk memastikan nama pemain tidak kosong atau hanya spasi
    const namaInput = document.getElementById('nama_pemain');
    if (namaInput) {
        namaInput.addEventListener('blur', function() {
            this.value = this.value.trim().replace(/\s+/g, ' ');
            if (this.value === '') {
                this.value = '';
            }
        });
    }

    // Validasi untuk memastikan sekolah dipilih
    const schoolSelect = document.getElementById('school_id');
    if (schoolSelect) {
        schoolSelect.addEventListener('change', function() {
            if (this.value === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    }
</script>
@endpush