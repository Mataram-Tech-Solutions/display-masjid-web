@extends('layouts.app')
@section('content')
{{-- <div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-3 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Imsak</p>
                <h5 class="font-weight-bolder">
                  {{ $jam[0] }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-center" style="font-size: 2rem;">🌘</div>
        </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-3 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Shubuh</p>
                <h5 class="font-weight-bolder">
                  {{ $jam[1] }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-center" style="font-size: 2rem;">🌅</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-3 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Syuruq</p>
                <h5 class="font-weight-bolder">
                  {{ $jam[2] }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-center" style="font-size: 2rem;">☀️</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-3 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Dzuhur</p>
                <h5 class="font-weight-bolder">
                  {{ $jam[3] }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-center" style="font-size: 2rem;">🌞</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-3 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Ashr</p>
                <h5 class="font-weight-bolder">
                  {{ $jam[4] }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-center" style="font-size: 2rem;">🌄</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-3 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Maghrib</p>
                <h5 class="font-weight-bolder">
                  {{ $jam[5] }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-center" style="font-size: 2rem;">🌇</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-3 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Isya</p>
                <h5 class="font-weight-bolder">
                  {{ $jam[6] }}
                </h5>
              </div>
            </div>
            <div class="col-4 text-center" style="font-size: 2rem;">🌙</div>
          </div>
        </div>
      </div>
    </div>
  </div> --}}
  <div class="row mt-4">
    <div class="col-lg-8 mb-lg-0 mb-4">
      <div class="card">
        <div class="card-header pb-0 p-3">
            <div class="d-flex justify-content-between">
                <h6 class="mb-2">Jadwal Imam & Khatib</h6>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table align-items-center">
                <tbody>
                    @foreach($jadwal as $jadwal)
                    <tr>
                        <td>
                            <div class="text-center">
                                <p class="text-xs font-weight-bold mb-0">Shalat:</p>
                                <h6 class="text-sm mb-0">{{ $jadwal->shalat }}</h6>
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                <p class="text-xs font-weight-bold mb-0">Imam:</p>
                                <h6 class="text-sm mb-0">
                                  @if ($jadwal->jdwlustadz == NULL)
                                  -
                                @else
                                Ust. {{$jadwal->jdwlustadz->name}}
                                @endif
                                </h6>
                            </div>
                        </td>
                        <td>
                          <div class="text-center">
                              <p class="text-xs font-weight-bold mb-0">Khatib:</p>
                              <h6 class="text-sm mb-0">
                                @if ($jadwal->jdwlkhatib == NULL)
                                  -
                                @else
                                Ust. {{$jadwal->jdwlkhatib->name}}
                                @endif
                              </h6>
                          </div>
                      </td>
                        <td class="align-middle text-sm">
                            <div class="col text-center">
                                <p class="text-xs font-weight-bold mb-0">Adzan:</p>
                                <h6 class="text-sm mb-0">
                                  @if(is_null($jadwal->waktu_adzan))
                                      -
                                  @else
                                    {{ substr($jadwal->waktu_adzan, 0, 5) }}
                                  @endif
                              </h6>
                            </div>
                        </td>
                        <td class="align-middle text-sm">
                            <div class="col text-center">
                                <p class="text-xs font-weight-bold mb-0">Iqomah:</p>
                                <h6 class="text-sm mb-0">
                                  @if(is_null($jadwal->waktu_iqomah))
                                      -
                                  @else
                                    {{ substr($jadwal->waktu_iqomah, 0, 5) }}
                                  @endif
                              </h6>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    </div>
    <div class="col-lg-4">
      <div class="card">
          <div class="card-header pb-0 p-3">
              <h6 class="mb-0">Jadwal Pengajian</h6>
          </div>
          <div class="card-body p-3">
              <ul class="list-group">
                  @foreach($kajian as $kajian)
                      <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                          <div class="d-flex align-items-center">
                              <div class="d-flex flex-column">
                                  <h6 class="mb-1 text-dark text-sm">{{ $kajian->judul }}</h6> <!-- Sesuaikan nama kolom -->
                                  <small class="text-muted">{{ $kajian->tgl_pelaksanaan }}</small> <!-- Sesuaikan nama kolom -->
                              </div>
                          </div>
                          <div class="d-flex">
                            <button 
                            class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto" 
                            data-bs-toggle="modal" 
                            data-bs-target="#jadwalDetailModal" 
                            data-nama="{{ $kajian->judul }}" 
                            data-tanggal="{{ $kajian->tgl_pelaksanaan }}" 
                            data-ulama="{{ optional($kajian->pemateri)->ustd == 'ustadz' ? 'Ust. ' . optional($kajian->pemateri)->name : (optional($kajian->pemateri)->name ? 'Ustz. ' . optional($kajian->pemateri)->name : '-') }}">
                            <i class="ni ni-bold-right" aria-hidden="true"></i>
                        </button>
                          </div>
                      </li>
                  @endforeach
              </ul>
          </div>
      </div>
  </div>

  <!-- Modal -->
<div class="modal fade" id="jadwalDetailModal" tabindex="-1" aria-labelledby="jadwalDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="jadwalDetailModalLabel">Detail Jadwal</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <!-- Konten detail jadwal -->
              <p><strong>Nama Kegiatan :</strong> <span id="namaKegiatan"></span></p>
              <p><strong>Tanggal :</strong> <span id="tanggal"></span></p>
              <p><strong>Ulama :</strong> <span id="ulama"></span></p>
              <!-- Tambahkan informasi lain sesuai kebutuhan -->
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
      </div>
  </div>
</div>

  

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tangkap semua tombol yang memiliki atribut data-bs-toggle="modal"
        const detailButtons = document.querySelectorAll('[data-bs-target="#jadwalDetailModal"]');

        detailButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Ambil data dari tombol
                const namaKegiatan = this.getAttribute('data-nama');
                const tanggal = this.getAttribute('data-tanggal');
                const ulama = this.getAttribute('data-ulama');

                // Set data ke elemen dalam modal
                document.getElementById('namaKegiatan').textContent = namaKegiatan;
                document.getElementById('tanggal').textContent = tanggal;
                document.getElementById('ulama').textContent = ulama;
            });
        });
    });
</script>

@endsection
