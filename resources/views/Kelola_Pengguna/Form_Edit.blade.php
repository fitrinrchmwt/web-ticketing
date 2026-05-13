<div class="modal fade" id="modalFormEdit" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route("pengguna.update") }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Data</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup">
          </button>
        </div>

        <div class="modal-body">
          <form id="formEditPengguna">
            <input type="hidden" name="id_pengguna" id="edit_id_pengguna" readonly>

            <!-- Nama -->
            <div class="mb-2">
              <label for="nama" class="form-label fw-bold small">Nama</label>
              <input type="text" class="form-control form-control-sm" id="edit_nama" name="nama">
            </div>

            <!-- Username -->
            <div class="mb-2">
              <label for="username" class="form-label fw-bold small">Username</label>
              <input type="text" class="form-control form-control-sm" id="edit_username" name="username">
            </div>

            <!-- Email -->
            <div class="mb-2">
              <label for="nama" class="form-label fw-bold small">Email</label>
              <input type="text" class="form-control form-control-sm" id="edit_email" name="email">
            </div>

            <!-- Password -->
            <div class="row mb-2">
              <label for="password" class="form-label fw-bold small">Password</label>
              <div class="col-sm-0">
                <div class="input-group">
                  <input type="password" class="form-control" id="edit_password"
                    placeholder="kosongkan jika tidak ganti password" name="password">
                  <span class="input-group-text" style="cursor:pointer; background:white;"
                    onclick="togglePassword('edit_password', this)">
                   <i class="bi bi-eye-slash"></i>
                  </span>
                </div>
              </div>
            </div>



            <!-- Konfirmasi Password -->
            <div class="row mb-2">
              <label for="konfirmasi_password" class="form-label fw-bold small">Konfirmasi Password</label>
              <div class="col-sm-0">
                <div class="input-group">
                  <input type="password" class="form-control" placeholder="kosongkan jika tidak ganti password"
                    id="edit_konfirmasi_password" name="konfirmasi_password">
                  <span class="input-group-text" style="cursor:pointer; background:white;"
                    onclick="togglePassword('edit_konfirmasi_password', this)">
                   <i class="bi bi-eye-slash"></i>
                  </span>
                </div>
              </div>
            </div>

            <!-- Level Pengguna -->
            <div class="mb-2">
              <label for="edit_id_role" class="form-label fw-bold small">Level Pengguna</label>
              <select id="edit_id_role" name="id_role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                @foreach ($list_role as $role)
                  <option value="{{ $role->id_role }}">
                    {{ $role->nama_role}}
                @endforeach
              </select>

            </div>

            <!-- Departemen -->
            <div class="mb-2">
              <label for="edit_id_departemen" class="form-label fw-bold small">Departemen</label>
              <select id="edit_id_departemen" name="id_departemen" class="form-control" required>
                <option value="">-- Pilih Departemen --</option>
                @foreach ($list_departemen as $departemen)
                  <option value="{{ $departemen->id_departemen }}">
                    {{ $departemen->nama_departemen }}
                @endforeach
              </select>
            </div>



        </div>
        <div class="modal-footer justify-content-end">
          <button type="submit" id="btnSave" class=" btn btn-primary ladda-button" data-style="expand-right">
            <span class="ladda-label">Simpan</span>
          </button>

          <span id="alertSuccess" style="color:#009900;font-weight: bold"></span>
          <span id="alertDanger" style="color:#eb3a28;font-weight: bold"></span>
        </div>
      </div>
    </form>
  </div>
</div>