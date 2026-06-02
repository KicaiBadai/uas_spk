@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Header halaman -->
    <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
        <a href="/schools" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <div>
            <h1 class="h2 mb-0">
                <i class="bi bi-building-gear text-warning me-2"></i> Edit Sekolah
            </h1>
            <p class="text-muted mt-1">Ubah informasi data sekolah</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <form action="/schools/{{ $school->id }}" method="POST" id="editForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-12">
                        <!-- Nama Sekolah -->
                        <div class="mb-4">
                            <label for="nama_sekolah" class="form-label fw-semibold">
                                <i class="bi bi-building me-1"></i> Nama Sekolah <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control form-control-lg @error('nama_sekolah') is-invalid @enderror"
                                   id="nama_sekolah"
                                   name="nama_sekolah"
                                   value="{{ old('nama_sekolah', $school->nama_sekolah) }}"
                                   placeholder="Contoh: SMAN 1 Jakarta, SMA Bina Bangsa, SMK Telkom"
                                   required>
                            <div class="form-text">Nama lengkap sekolah atau institusi.</div>
                            @error('nama_sekolah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Informasi tambahan: statistik pemain -->
                        <div class="alert alert-info mt-3" role="alert">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <strong>Informasi Sekolah:</strong>
                            <br>
                            <i class="bi bi-people-fill me-1"></i> Jumlah pemain terdaftar: 
                            <span class="fw-bold">{{ $school->players->count() }} pemain</span>
                        </div>

                        <!-- Peringatan jika sekolah memiliki pemain -->
                        @if($school->players->count() > 0)
                            <div class="alert alert-warning" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Perhatian:</strong> Sekolah ini memiliki {{ $school->players->count() }} pemain terdaftar.
                                Mengubah nama sekolah tidak akan mempengaruhi data pemain.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between mt-4 pt-3">
                    <a href="/schools" class="btn btn-outline-secondary btn-lg px-4">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                        <i class="bi bi-check-circle me-2"></i> Perbarui Sekolah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Validasi nama sekolah: minimal 3 karakter, tidak boleh kosong, trim spasi berlebih
    const namaInput = document.getElementById('nama_sekolah');
    if (namaInput) {
        // Trim spasi saat input kehilangan fokus
        namaInput.addEventListener('blur', function() {
            // Trim spasi di awal dan akhir
            let trimmedValue = this.value.trim();
            
            // Hapus spasi berlebih di tengah (multiple spaces menjadi satu)
            trimmedValue = trimmedValue.replace(/\s+/g, ' ');
            
            this.value = trimmedValue;
            
            // Validasi minimal panjang
            if (this.value.length > 0 && this.value.length < 3) {
                this.classList.add('is-invalid');
                // Buat atau tambah pesan error custom
                let feedback = this.nextElementSibling;
                while (feedback && !feedback.classList.contains('invalid-feedback')) {
                    feedback = feedback.nextElementSibling;
                }
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = 'Nama sekolah minimal 3 karakter.';
                }
            } else if (this.value === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        // Hapus error saat user mulai mengetik
        namaInput.addEventListener('input', function() {
            if (this.value.trim().length >= 3 || this.value.trim() === '') {
                this.classList.remove('is-invalid');
            }
        });
    }

    // Validasi form sebelum submit
    const form = document.getElementById('editForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // Cek nama sekolah
            if (!namaInput.value || namaInput.value.trim().length < 3) {
                namaInput.classList.add('is-invalid');
                
                // Set pesan error
                let feedback = namaInput.nextElementSibling;
                while (feedback && !feedback.classList.contains('invalid-feedback')) {
                    feedback = feedback.nextElementSibling;
                }
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = 'Nama sekolah harus diisi minimal 3 karakter.';
                }
                
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                // Scroll ke field error
                namaInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                namaInput.focus();
            }
        });
    }
</script>
@endpush