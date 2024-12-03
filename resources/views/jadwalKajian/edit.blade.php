@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Edit Jadwal Sholat</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form action="{{ route('jadwalkajian.update', $oldval->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row px-4">
                        <!-- Form Sholat -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="judul" class="form-control-label">Judul :</label>
                                <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $oldval->judul) }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ulama" class="form-control-label">ulama :</label>
                                <select class="form-control" id="ulama" name="ulama" required>
                                    <option value="" disabled {{ is_null($oldval->ulama) ? 'selected' : '' }}>--Pilih ulama--</option>
                                    @foreach ($ulama as $ulamas)                               
                                    <option value="{{ $ulamas->id }}" 
                                        {{ $oldval->ulama == $ulamas->id ? 'selected' : '' }}>
                                        @if ($ulamas->ustd == "ustadz")
                                        Ust. {{ $ulamas->name }}

                                        @else
                                        Ustz. {{ $ulamas->name }}

                                        @endif
                                    </option>
                                @endforeach
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pelaksanaan_date" class="form-control-label">Tanggal Pelaksanaan :</label>
                                <input type="date" class="form-control" id="pelaksanaan_date" name="pelaksanaan_date" 
                                value="{{ old('pelaksanaan_date', date('Y-m-d', strtotime($oldval->tgl_pelaksanaan))) }}">
                                                        </div>
                        </div>                     
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="iqomah" class="form-control-label">Jam Pelaksanaan:</label>
                                <div class="d-flex align-items-center">
                                    <!-- Input for Hours -->
                                    <input type="number" class="form-control me-2" id="pelaksanaan_hour" name="pelaksanaan_hour" 
                                        value="{{ old('pelaksanaan_hour', date('H', strtotime($oldval->tgl_pelaksanaan))) }}" 
                                        min="0" max="23" placeholder="HH" required>
                                    <!-- Separator -->
                                    <span class="mx-1 me-2">:</span>
                                    <!-- Input for Minutes -->
                                    <input type="number" class="form-control" id="pelaksanaan_minute" name="pelaksanaan_minute" 
                                        value="{{ old('pelaksanaan_minute', date('i', strtotime($oldval->tgl_pelaksanaan))) }}" 
                                        min="0" max="59" placeholder="MM" required>
                                </div>
                            </div>
                        </div>    
                    <!-- Submit Button -->
                    <div class="row px-4 mt-3">
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('jadwalkajian.index') }}" class="btn btn-secondary">Kembali</a>
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