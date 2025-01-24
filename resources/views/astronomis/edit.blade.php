@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Edit Data Astronomis</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form action="{{ route('astronomis.update', $oldval->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row px-4">
                        <!-- Form Sholat -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="latitude" class="form-control-label">Latitude :</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude', $oldval->latitude) }}">
                            </div>
                        </div>  
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="longitude" class="form-control-label">Longitude :</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude', $oldval->longitude) }}">
                            </div>
                        </div>  
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ketinggian_laut" class="form-control-label">Ketinggian Laut :</label>
                                <input type="text" class="form-control" id="ketinggian_laut" name="ketinggian_laut" value="{{ old('ketinggian_laut', $oldval->ketinggian_laut) }}">
                            </div>
                        </div>  
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sudut_fajarsenja" class="form-control-label">Sudut Fajar Senja :</label>
                                <input type="text" class="form-control" id="sudut_fajarsenja" name="sudut_fajarsenja" value="{{ old('sudut_fajarsenja', $oldval->sudut_fajarsenja) }}">
                            </div>
                        </div>  
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sudut_malamsenja" class="form-control-label">Sudut malam Senja :</label>
                                <input type="text" class="form-control" id="sudut_malamsenja" name="sudut_malamsenja" value="{{ old('sudut_malamsenja', $oldval->sudut_malamsenja) }}">
                            </div>
                        </div>  
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gmt" class="form-control-label">Zona Waktu :</label>
                                <select class="form-control" id="gmt" name="gmt">
                                    <option value="" disabled>--Pilih Zona Waktu--</option>
                                    <option value="1" {{ old('gmt', $oldval->gmt) == '1' ? 'selected' : '' }}>WIB 7+</option>
                                    <option value="2" {{ old('gmt', $oldval->gmt) == '2' ? 'selected' : '' }}>WITA 8+</option>
                                    <option value="3" {{ old('gmt', $oldval->gmt) == '3' ? 'selected' : '' }}>WIT 9+</option>
                                </select>
                            </div>
                        </div>                        
                        
                    <!-- Submit Button -->
                    <div class="row px-4 mt-3">
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('astronomis.index') }}" class="btn btn-secondary">Kembali</a>
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