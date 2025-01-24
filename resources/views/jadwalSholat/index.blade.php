@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>Jadwal Sholat</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sholat</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jeda Iqomah</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Akurasi Adzan</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Buzzer Iqomah</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Audio Adzan</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Audio Murothal</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status Audio Adzan</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status Audio Murottal</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Imam</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Khatib</th>
                  <th class="text-secondary opacity-7 ms-4"></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($list as $lists)
                <tr>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ $lists->shalat }}</span>
                    </td>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ $lists->jeda_iqomah }}</span>
                    </td>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ $lists->akurasi_adzan ?? '-' }}</span>
                    </td>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ $lists->buzzeriqomah ?? '-'  }}</span>
                    </td>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ $lists->audioadzan->name ?? '-'  }}</span>
                    </td>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ $lists->audiomur->name ?? '-'  }}</span>
                    </td>
                    <td class="align-middle text-center">
                        <span class="badge badge-sm {{ $lists->audstat == '1' ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                            @if ($lists->audstat == 1)
                                Aktif
                            @else
                                Non-Aktif
                            @endif
                        </span>
                    </td>
                    <td class="align-middle text-center">
                        <span class="badge badge-sm {{ $lists->audmurstat == '1' ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                            @if ($lists->audmurstat == 1)
                            Aktif
                        @else
                            Non-Aktif
                        @endif
                        </span>
                    </td>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">
                            @if ($lists->jdwlustadz == NULL)
                                -
                            @else
                            Ust. {{ $lists->jdwlustadz->name }}
                            @endif
                        </span>
                    </td>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">
                            @if ($lists->jdwlkhatib == NULL)
                                -
                            @else
                            Ust. {{ $lists->jdwlkhatib->name }}
                            @endif
                        </span>
                    </td>
                    <td class="align-middle text-center">
                        <form action="{{ route('jadwalsholat.edit', $lists->id) }}" method="GET">
                            <button type="submit" class="btn btn-sm btn-warning">Edit Data</button>
                        </form>
                    </td>
                </tr>
                @endforeach 
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>  
  <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-body">
                <div class="text-success mb-3">
                    <i class="fas fa-check-circle fa-3x"></i>
                </div>
                <h5 class="modal-title mb-2" id="successModalLabel">Berhasil!</h5>
                <p>{{ session('success') }}</p>
                <button type="button" class="btn btn-primary mt-3" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
  @if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Trigger modal pop-up
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    });
</script>
@endif
  @endsection
