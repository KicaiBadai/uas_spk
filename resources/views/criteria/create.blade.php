@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <!-- Header halaman -->
    <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
        <a href="/criteria" class="btn btn-outline-secondary me-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <div>
            <h1 class="h2 mb-0">
                <i class="bi bi-plus-circle text-success me-2"></i> Tambah Kriteria
            </h1>
            <p class="text-muted mt-1">Tambahkan kriteria baru untuk perhitungan TOPSIS pemain futsal</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <form action="/criteria" method="POST" id="createForm">
                @csrf

                <div class="row g-4">
                    <!-- Kode Kriteria -->
                    <div class="col-md-6">
                        <label for="kode" class="form-label fw-semibold">
                            <i class="bi bi-tag me-1"></i> Kode Kriteria <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control form-control-lg @error('kode') is-invalid @enderror"
                               id="kode"
                               name="kode"
                               value="{{ old('kode') }}"
                               placeholder="Contoh: C1, KECEPATAN, A1"
                               required>
                        <div class="form-text">Kode unik untuk identifikasi kriteria (maksimal 10 karakter).</div>
                        @error('kode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Kriteria -->
                    <div class="col-md-6">
                        <label for="nama_kriteria" class="form-label fw-semibold">
                            <i class="bi bi-card-text me-1"></i> Nama Kriteria <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control form-control-lg @error('nama_kriteria') is-invalid @enderror"
                               id="nama_kriteria"
                               name="nama_kriteria"
                               value="{{ old('nama_kriteria') }}"
                               placeholder="Contoh: Kecepatan, Akurasi Tembakan, Kerja Sama Tim"
                               required>
                        <div class="form-text">Nama lengkap kriteria yang akan dinilai.</div>
                        @error('nama_kriteria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Bobot -->
                    <div class="col-md-6">
                        <label for="bobot" class="form-label fw-semibold">
                            <i class="bi bi-percent me-1"></i> Bobot <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                               step="0.01"
                               class="form-control form-control-lg @error('bobot') is-invalid @enderror"
                               id="bobot"
                               name="bobot"
                               value="{{ old('bobot') }}"
                               placeholder="0 - 100"
                               min="0"
                               max="100"
                               required>
                        <div class="form-text">Bobot kriteria (0–100). Semakin tinggi nilai bobot, semakin penting kriteria ini.</div>
                        @error('bobot')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tipe -->
                    <div class="col-md-6">
                        <label for="tipe" class="form-label fw-semibold">
                            <i class="bi bi-arrow-left-right me-1"></i> Tipe Kriteria <span class="text-danger">*</span>
                        </label>
                        <select class="form-select form-select-lg @error('tipe') is-invalid @enderror" id="tipe" name="tipe" required>
                            <option value="benefit" {{ old('tipe') == 'benefit' ? 'selected' : '' }}>
                                ✅ Benefit (semakin besar nilai, semakin baik)
                            </option>
                            <option value="cost" {{ old('tipe') == 'cost' ? 'selected' : '' }}>
                                ⚠️ Cost (semakin kecil nilai, semakin baik)
                            </option>
                        </select>
                        <div class="form-text">
                            <span class="badge bg-success">Benefit</span> = nilai tinggi lebih baik (contoh: kecepatan)<br>
                            <span class="badge bg-warning text-dark">Cost</span> = nilai rendah lebih baik (contoh: waktu cedera)
                        </div>
                        @error('tipe')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Informasi tambahan -->
                <div class="alert alert-info mt-4" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <strong>Tips:</strong> Pastikan bobot dan tipe kriteria sudah sesuai dengan kebutuhan perhitungan TOPSIS. Anda bisa mengeditnya nanti.
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between mt-4 pt-3">
                    <a href="/criteria" class="btn btn-outline-secondary btn-lg px-4">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                        <i class="bi bi-save me-2"></i> Simpan Kriteria
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Validasi front-end untuk bobot
    const bobotInput = document.getElementById('bobot');
    if (bobotInput) {
        bobotInput.addEventListener('input', function() {
            let val = parseFloat(this.value);
            if (isNaN(val)) {
                this.value = '';
            } else if (val < 0) {
                this.value = 0;
            } else if (val > 100) {
                this.value = 100;
            }
        });

        bobotInput.addEventListener('blur', function() {
            let val = parseFloat(this.value);
            if (isNaN(val)) {
                this.value = '';
            } else if (val < 0) {
                this.value = 0;
            } else if (val > 100) {
                this.value = 100;
            }
        });
    }

    // Validasi kode agar tidak mengandung spasi (opsional)
    const kodeInput = document.getElementById('kode');
    if (kodeInput) {
        kodeInput.addEventListener('blur', function() {
            this.value = this.value.toUpperCase().replace(/\s/g, '');
        });
    }
</script>
@endpush