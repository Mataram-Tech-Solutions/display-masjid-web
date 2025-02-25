@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Setting Waktu</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form action="{{ route('displayutama.store') }}" method="POST">
                    @csrf
                    <div class="row px-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tanggal" class="form-control-label">Tanggal :</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                value="{{ old('tanggal', \Carbon\Carbon::parse(Cache::get('post_datetime', now()))->format('Y-m-d')) }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jam" class="form-control-label">Jam :</label>
                                <div class="d-flex align-items-center">
                                    <!-- Input for Hours -->
                                    <input type="number" class="form-control me-2" id="jam_hour" name="jam_hour" 
                                    value="{{ old('jam_hour', \Carbon\Carbon::parse(Cache::get('post_datetime', now()))->format('H')) }}"
                                    min="0" max="23" placeholder="HH" required>
                                    <!-- Separator -->
                                    <span class="mx-1 me-2">:</span>
                                    <!-- Input for Minutes -->
                                    <input type="number" class="form-control" id="menit_minute" name="menit_minute" 
                                        value="{{ old('menit_minute', \Carbon\Carbon::parse(Cache::get('post_datetime', now()))->format('i')) }}" 
                                        min="0" max="59" placeholder="MM" required>
                                </div>
                            </div>
                        </div>
                        
                    <!-- Submit Button -->
                    <div class="row px-4 mt-3">
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('setwaktu') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 
<!-- Modal Error -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="text-danger mb-3">
                    <i class="fas fa-times-circle fa-3x"></i> <!-- Ikon silang -->
                </div>
                <h5 class="modal-title mb-2" id="errorModalLabel">Gagal!</h5>
                <p>{{ session('error') }}</p>
                <button type="button" class="btn btn-danger mt-3" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Trigger modal pop-up
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    });
</script>
@endif

@endsection