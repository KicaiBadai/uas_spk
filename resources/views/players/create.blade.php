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
                <i class="bi bi-person-plus-fill text-success me-2"></i> Tambah Pemain
            </h1>
            <p class="text-muted mt-1">Tambahkan data pemain futsal baru untuk penilaian TOPSIS</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <form action="/players" method="POST" id="createForm">
                @csrf

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
                                <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
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
                               value="{{ old('nama_pemain') }}"
                               placeholder="Contoh: Muhammad Rizki, Ahmad Fauzan, Budi Santoso"
                               required>
                        <div class="form-text">Nama lengkap pemain futsal (minimal 3 karakter).</div>
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
                            <option value="Goalkeeper" {{ old('posisi') == 'Goalkeeper' ? 'selected' : '' }}>
                                🧤 Goalkeeper (Penjaga Gawang)
                            </option>
                            <option value="Defender" {{ old('posisi') == 'Defender' ? 'selected' : '' }}>
                                🛡️ Defender (Pemain Bertahan)
                            </option>
                            <option value="Midfielder" {{ old('posisi') == 'Midfielder' ? 'selected' : '' }}>
                                ⚡ Midfielder (Gelandang)
                            </option>
                            <option value="Forward" {{ old('posisi') == 'Forward' ? 'selected' : '' }}>
                                🎯 Forward (Penyerang)
                            </option>
                        </select>
                        <div class="form-text">
                            <span class="badge bg-danger">Goalkeeper</span>
                            <span class="badge bg-info">Defender</span>
                            <span class="badge bg-warning">Midfielder</span>
                            <span class="badge bg-success">Forward</span>
                            <span class="ms-2 text-muted">Pilih posisi bermain pemain.</span>
                        </div>
                        @error('posisi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Informasi tambahan -->
                <div class="alert alert-info mt-4" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <strong>Tips:</strong> Setelah menambahkan pemain, jangan lupa untuk mengisi penilaian pemain pada menu <strong>Penilaian</strong> agar bisa diproses dengan metode TOPSIS.
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between mt-4 pt-3">
                    <a href="/players" class="btn btn-outline-secondary btn-lg px-4">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                        <i class="bi bi-save me-2"></i> Simpan Pemain
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Validasi nama pemain: minimal 3 karakter, tidak boleh kosong, trim spasi berlebih
    const namaInput = document.getElementById('nama_pemain');
    if (namaInput) {
        namaInput.addEventListener('blur', function() {
            // Trim spasi di awal dan akhir
            this.value = this.value.trim();
            
            // Hapus spasi berlebih di tengah (multiple spaces menjadi satu)
            this.value = this.value.replace(/\s+/g, ' ');
            
            // Validasi minimal panjang
            if (this.value.length > 0 && this.value.length < 3) {
                this.classList.add('is-invalid');
                // Buat atau tambah pesan error custom (opsional)
                let feedback = this.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = 'Nama pemain minimal 3 karakter.';
                }
            } else if (this.value === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        namaInput.addEventListener('input', function() {
            if (this.value.length >= 3 || this.value === '') {
                this.classList.remove('is-invalid');
            }
        });
    }

    // Validasi sekolah harus dipilih
    const schoolSelect = document.getElementById('school_id');
    if (schoolSelect) {
        schoolSelect.addEventListener('change', function() {
            if (this.value !== '') {
                this.classList.remove('is-invalid');
            }
        });
    }

    // Validasi posisi harus dipilih
    const posisiSelect = document.getElementById('posisi');
    if (posisiSelect) {
        posisiSelect.addEventListener('change', function() {
            if (this.value !== '') {
                this.classList.remove('is-invalid');
            }
        });
    }

    // Validasi form sebelum submit
    const form = document.getElementById('createForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Cek sekolah
            if (!schoolSelect.value) {
                schoolSelect.classList.add('is-invalid');
                isValid = false;
            }
            
            // Cek nama pemain
            if (!namaInput.value || namaInput.value.length < 3) {
                namaInput.classList.add('is-invalid');
                isValid = false;
            }
            
            // Cek posisi
            if (!posisiSelect.value) {
                posisiSelect.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                // Scroll ke field pertama yang error
                const firstError = document.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }
        });
    }
</script>
@endpush