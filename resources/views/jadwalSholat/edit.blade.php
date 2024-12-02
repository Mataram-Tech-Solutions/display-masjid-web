@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Edit Jadwal Sholat</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form action="{{ route('jadwalsholat.update', $sebelumnya->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row px-4">
                        <!-- Form Sholat -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sholat" class="form-control-label">Sholat :</label>
                                <input type="hidden" name="shalat" value="{{ old('sholat', $sebelumnya->shalat) }}">
                                <input type="text" class="form-control disabled" id="sholat" name="sholat" value="{{ old('sholat', $sebelumnya->shalat) }}"disabled>
                            </div>
                        </div>
                        <!-- Form Adzan -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="adzan" class="form-control-label">Adzan :</label>
                                <div class="d-flex align-items-center">
                                    <!-- Input for Hours -->
                                    <input type="number" class="form-control me-2" id="adzan_hour" name="adzan_hour" 
                                        value="{{ old('adzan_hour', date('H', strtotime($sebelumnya->waktu_adzan))) }}" 
                                        min="0" max="23" placeholder="HH" required>
                                    <!-- Separator -->
                                    <span class="mx-1 me-2">:</span>
                                    <!-- Input for Minutes -->
                                    <input type="number" class="form-control" id="adzan_minute" name="adzan_minute" 
                                        value="{{ old('adzan_minute', date('i', strtotime($sebelumnya->waktu_adzan))) }}" 
                                        min="0" max="59" placeholder="MM" required>
                                </div>
                            </div>
                        </div> 
                        <!-- Form Iqomah -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="iqomah" class="form-control-label">Iqomah :</label>
                                <div class="d-flex align-items-center">
                                    <!-- Input for Hours -->
                                    <input type="number" class="form-control me-2" id="iqomah_hour" name="iqomah_hour" 
                                        value="{{ old('iqomah_hour', date('H', strtotime($sebelumnya->waktu_iqomah))) }}" 
                                        min="0" max="23" placeholder="HH" required>
                                    <!-- Separator -->
                                    <span class="mx-1 me-2">:</span>
                                    <!-- Input for Minutes -->
                                    <input type="number" class="form-control" id="iqomah_minute" name="iqomah_minute" 
                                        value="{{ old('iqomah_minute', date('i', strtotime($sebelumnya->waktu_iqomah))) }}" 
                                        min="0" max="59" placeholder="MM" required>
                                </div>
                            </div>
                        </div> 
                        <!-- Row 2 -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="buzzer" class="form-control-label">Buzzer Iqomah :</label>
                                    <input type="number" class="form-control" id="buzzer" name="buzzer" 
                                        value="{{ old('buzzer', $sebelumnya->buzzeriqomah) }}" 
                                        min="0" max="20" required>
                            </div>
                        </div> 
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="audioadzan" class="form-control-label">Audio Adzan :</label>
                                <select class="form-control" id="audioadzan" name="audioadzan">
                                    <option value="" {{ old('audioadzan', $sebelumnya->audioadzan->id ?? null) === null ? 'selected' : 'disable' }} >
                                        --Pilih Audio--
                                    </option>
                                
                                    <!-- Jika ada data dari old() atau $sebelumnya, tampilkan sebagai opsi terpilih -->
                                    @if(old('audioadzan', $sebelumnya->audioadzan->id ?? null))
                                        <option value="{{ old('audioadzan', $sebelumnya->audioadzan->id) }}" selected>
                                            {{ old('audioadzan', $sebelumnya->audioadzan->name) }}
                                        </option>
                                    @endif
                                
                                    <!-- Semua opsi dari tabel audio -->
                                    @foreach ($audio as $audios)
                                        <!-- Cegah duplikasi data jika old() sudah menampilkan data -->
                                        @if(old('audioadzan', $sebelumnya->audioadzan->id ?? null) != $audios->id)
                                            <option value="{{ $audios->id }}">
                                                {{ $audios->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>                        
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="audiomur" class="form-control-label">Audio Murrothal :</label>
                                <select class="form-control" id="audiomur" name="audiomur">
                                    <!-- Opsi pertama (default, selalu muncul di awal) -->
                                    <option value="" {{ old('audiomur', $sebelumnya->audiomur->id ?? null) === null ? 'selected' : 'disable' }} >
                                        --Pilih Audio--
                                    </option>
                                
                                    <!-- Jika ada data dari old() atau $sebelumnya, tampilkan sebagai opsi terpilih -->
                                    @if(old('audiomur', $sebelumnya->audiomur->id ?? null))
                                        <option value="{{ old('audiomur', $sebelumnya->audiomur->id) }}" selected>
                                            {{ old('audiomur', $sebelumnya->audiomur->name) }}
                                        </option>
                                    @endif
                                
                                    <!-- Semua opsi dari tabel audio -->
                                    @foreach ($audio as $audios)
                                        <!-- Cegah duplikasi data jika old() sudah menampilkan data -->
                                        @if(old('audiomur', $sebelumnya->audiomur->id ?? null) != $audios->id)
                                            <option value="{{ $audios->id }}">
                                                {{ $audios->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                
                                
                            </div>
                        </div>     
                        <!-- Row 3 -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="flexSwitchCheckDefault" class="form-control-label">Adzan Automatis:</label>
                                <div class="form-check form-switch">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        role="switch" 
                                        id="flexSwitchCheckDefault" 
                                        name="adzan_automatis"
                                        @if ($adzanstat == true)
                                            checked
                                        @else
                                            
                                        @endif>
                                </div>
                            </div>
                        </div>
                                                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="flexSwitchCheckDefault" class="form-control-label">Murrothal Automatis:</label>
                                <div class="form-check form-switch">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        role="switch" 
                                        id="flexSwitchCheckDefault" 
                                        name="murrothal_automatis"
                                        @if ($murstat == true)
                                            checked
                                        @else
                                            
                                        @endif>
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="imam" class="form-control-label">Imam :</label>
                                <select class="form-control" id="imam" name="imam" required>
                                    <option value="" disabled>--Pilih Imam--</option>

                                    @if ( $sebelumnya->imam != null)
                                        <option value="" >--Kosong--</option>
                                        <option value="{{$sebelumnya->jdwlustadz->id}}" selected>  Ust. {{ old('imam', $sebelumnya->jdwlustadz->name) }}</option>
                                    @else
                                    <option value="" selected>--Kosong--</option>

                                        
                                    @endif

                                    @foreach ($ustad as $ustads)
                                    @if ($sebelumnya->jdwlustadz == null)
                                    <option value="{{ $ustads->id }}" >Ust. {{ $ustads->name }}</option>
                                    @elseif($ustads->id != $sebelumnya->jdwlustadz->id) <!-- Pastikan tidak duplikasi -->
                                    <option value="{{ $ustads->id }}" 
                                        {{ old('imam', $sebelumnya->imam->id ?? null) == $ustads->id ? 'selected' : '' }}>
                                        Ust. {{ $ustads->name }}
                                    </option>
                                    @endif
                                
                                @endforeach
                                    
                                </select>
                            </div>
                        </div>
                                                                     
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="khatib" class="form-control-label">Khatib :</label>
                                <select class="form-control" id="khatib" name="khatib" required>
                                    <option value="" disabled>--Pilih khatib--</option>

                                    @if ( $sebelumnya->khatib != null)
                                        <option value="" >--Kosong--</option>
                                        <option value="{{$sebelumnya->jdwlkhatib->id}}" selected>  Ust. {{ old('khatib', $sebelumnya->jdwlkhatib->name) }}</option>
                                    @else
                                    <option value="" selected>--Kosong--</option>

                                        
                                    @endif

                                    @foreach ($ustad as $ustads)
                                    @if ($sebelumnya->jdwlkhatib == null)
                                    <option value="{{ $ustads->id }}" >Ust. {{ $ustads->name }}</option>
                                    @elseif($ustads->id != $sebelumnya->jdwlkhatib->id) <!-- Pastikan tidak duplikasi -->
                                    <option value="{{ $ustads->id }}" 
                                        {{ old('khatib', $sebelumnya->khatib->id ?? null) == $ustads->id ? 'selected' : '' }}>
                                        Ust. {{ $ustads->name }}
                                    </option>
                                    @endif
                                
                                @endforeach
                                    
                                </select>
                            </div>
                        </div>
                        
                        
                    <!-- Submit Button -->
                    <div class="row px-4 mt-3">
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('jadwalsholat.index') }}" class="btn btn-secondary">Kembali</a>
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