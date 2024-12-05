@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>Running Text</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-0">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Running Text</th>
                  <th class="text-secondary opacity-7 ms-4"></th>
                  <th class="text-secondary opacity-7 ms-4"></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($runtxt as $runtxts)
                <tr>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                    </td>
                    <td class="align-middle text-center">
                        <span class="text-secondary text-xs font-weight-bold">{{ $runtxts->txt}}</span>
                    </td>
                    <td class="align-middle text-center">
                        <form action="{{ route('runtxt.edit', $runtxts->id) }}" method="GET">
                            <button type="submit" class="btn btn-sm btn-warning">Edit Data</button>
                        </form>
                    </td>
                    <td class="align-middle text-center">
                        <form action="{{ route('runtxt.destroy', $runtxts->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button  type="button" 
                            class="btn btn-sm btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteConfirmationModal"
                            onclick="setDeleteForm('{{ route('runtxt.destroy', $runtxts->id) }}')">Hapus Data</button>
                        </form>
                    </td>
                </tr>
                @endforeach 
            </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer pb-0 pt-2 d-flex justify-content-end align-items-center">
            <form action="{{ route('runtxt.create') }}" method="GET">
                <button type="submit" class="btn btn-sm btn-primary">Tambah Text</button>
            </form>
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

<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="text-danger mb-3">

                <i class="fas fa-question-circle fa-3x text-warning"></i>
                </div>
                <h5 class="modal-title mb-2">Yakin menghapus data ini?</h5>
                <div class="row g-1 justify-content-center">
                    <div class="col-auto">
                        <form id="deleteForm" action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">Ya</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Tidak</button>
                    </div>
                </div>
                
                
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
@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Trigger modal pop-up
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    });
</script>
@endif
<script>
    function setDeleteForm(actionUrl) {
        var form = document.getElementById('deleteForm');
        form.action = actionUrl;
    }
</script>
  @endsection
