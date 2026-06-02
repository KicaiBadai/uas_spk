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
                <i class="bi bi-building-add text-success me-2"></i> Tambah Sekolah
            </h1>
            <p class="text-muted mt-1">Tambahkan data sekolah baru untuk tim futsal</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <form action="/schools" method="POST" id="createForm">
                @csrf

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
                                   value="{{ old('nama_sekolah') }}"
                                   placeholder="Contoh: SMAN 1 Jakarta, SMA Bina Bangsa, SMK Telkom"
                                   required
                                   autofocus>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Nama lengkap sekolah atau institusi (minimal 3 karakter, maksimal 100 karakter).
                            </div>
                            @error('nama_sekolah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Informasi tambahan -->
                        <div class="alert alert-info mt-3" role="alert">
                            <i class="bi bi-lightbulb-fill me-2"></i>
                            <strong>Tips:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Gunakan nama sekolah yang lengkap dan resmi.</li>
                                <li>Hindari penggunaan singkatan yang tidak umum.</li>
                                <li>Setelah menambahkan sekolah, Anda bisa menambahkan pemain dari sekolah tersebut.</li>
                            </ul>
                        </div>

                        <!-- Preview nama sekolah (opsional) -->
                        <div class="mt-3 p-3 bg-light rounded-3 d-none" id="previewCard">
                            <small class="text-muted d-block mb-1">
                                <i class="bi bi-eye me-1"></i> Pratinjau:
                            </small>
                            <span id="previewText" class="fw-semibold text-primary"></span>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between mt-4 pt-3">
                    <a href="/schools" class="btn btn-outline-secondary btn-lg px-4">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                        <i class="bi bi-save me-2"></i> Simpan Sekolah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const namaInput = document.getElementById('nama_sekolah');
    const previewCard = document.getElementById('previewCard');
    const previewText = document.getElementById('previewText');
    
    // Fungsi untuk membersihkan spasi berlebih
    function cleanSpacing(str) {
        return str.trim().replace(/\s+/g, ' ');
    }
    
    // Validasi dan preview real-time
    if (namaInput) {
        // Event saat mengetik (untuk preview)
        namaInput.addEventListener('input', function() {
            let rawValue = this.value;
            let cleanedValue = cleanSpacing(rawValue);
            
            // Update preview jika ada teks
            if (cleanedValue.length > 0) {
                previewText.textContent = cleanedValue;
                previewCard.classList.remove('d-none');
            } else {
                previewCard.classList.add('d-none');
            }
            
            // Hapus class error saat mengetik
            if (cleanedValue.length >= 3 || cleanedValue.length === 0) {
                this.classList.remove('is-invalid');
            }
        });
        
        // Event saat kehilangan fokus (untuk validasi dan formatting)
        namaInput.addEventListener('blur', function() {
            let cleanedValue = cleanSpacing(this.value);
            this.value = cleanedValue;
            
            // Validasi
            if (cleanedValue.length === 0) {
                this.classList.add('is-invalid');
                // Update pesan error
                let feedback = this.nextElementSibling;
                while (feedback && !feedback.classList.contains('invalid-feedback')) {
                    feedback = feedback.nextElementSibling;
                }
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = 'Nama sekolah wajib diisi.';
                }
                previewCard.classList.add('d-none');
            } 
            else if (cleanedValue.length < 3) {
                this.classList.add('is-invalid');
                let feedback = this.nextElementSibling;
                while (feedback && !feedback.classList.contains('invalid-feedback')) {
                    feedback = feedback.nextElementSibling;
                }
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = 'Nama sekolah minimal 3 karakter.';
                }
            }
            else if (cleanedValue.length > 100) {
                this.classList.add('is-invalid');
                let feedback = this.nextElementSibling;
                while (feedback && !feedback.classList.contains('invalid-feedback')) {
                    feedback = feedback.nextElementSibling;
                }
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = 'Nama sekolah maksimal 100 karakter.';
                }
            }
            else {
                this.classList.remove('is-invalid');
            }
            
            // Update preview
            if (cleanedValue.length > 0 && cleanedValue.length >= 3) {
                previewText.textContent = cleanedValue;
                previewCard.classList.remove('d-none');
            } else {
                previewCard.classList.add('d-none');
            }
        });
    }
    
    // Validasi form sebelum submit
    const form = document.getElementById('createForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            let cleanedValue = cleanSpacing(namaInput.value);
            
            // Cek nama sekolah
            if (!cleanedValue || cleanedValue.length < 3) {
                namaInput.classList.add('is-invalid');
                
                // Set pesan error
                let feedback = namaInput.nextElementSibling;
                while (feedback && !feedback.classList.contains('invalid-feedback')) {
                    feedback = feedback.nextElementSibling;
                }
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    if (!cleanedValue) {
                        feedback.textContent = 'Nama sekolah wajib diisi.';
                    } else if (cleanedValue.length < 3) {
                        feedback.textContent = 'Nama sekolah minimal 3 karakter.';
                    }
                }
                
                isValid = false;
            } else if (cleanedValue.length > 100) {
                namaInput.classList.add('is-invalid');
                let feedback = namaInput.nextElementSibling;
                while (feedback && !feedback.classList.contains('invalid-feedback')) {
                    feedback = feedback.nextElementSibling;
                }
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = 'Nama sekolah maksimal 100 karakter.';
                }
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                // Scroll ke field error
                namaInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                namaInput.focus();
            } else {
                // Bersihkan input sebelum submit
                namaInput.value = cleanedValue;
            }
        });
    }
</script>
@endpush