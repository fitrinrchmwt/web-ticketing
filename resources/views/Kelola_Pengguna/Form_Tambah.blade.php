<div class="modal fade" id="modalFormTambah" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('pengguna.create') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup">
          </button>
        </div>

        <div class="modal-body">

          <input type="hidden" name="id_pengguna" value="{{ $kodeOtomatis }}" readonly>

          <!-- Nama -->
          <div class="mb-2">
            <label for="nama" class="form-label fw-bold small">Nama</label>
            <input type="text" class="form-control form-control-sm" id="nama" name="nama" placeholder="Masukan Nama"
              value="" required>
          </div>

          <!-- Username -->
          <div class="mb-2">
            <label for="username" class="form-label fw-bold small">Username</label>
            <input type="text" class="form-control form-control-sm" id="username" name="username"
              placeholder="Masukan Username" value="" required>
          </div>


          <!-- Email -->
          <div class="mb-2">
            <label for="email" class="form-label fw-bold small">Email</label>
            <input type="text" class="form-control form-control-sm" id="email" name="email" placeholder="Masukan Email"
              value="" required>
          </div>

          <!-- Password -->
          <div class="row mb-2">
            <label for="password" class="form-label fw-bold small">Password</label>
            <div class="col-sm-0">
              <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" required>
                <span class="input-group-text" style="cursor:pointer; background:white;"
                  onclick="togglePassword('password', this)">
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
                <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password"
                  required>
                <span class="input-group-text" style="cursor:pointer; background:white;"
                  onclick="togglePassword('konfirmasi_password', this)">
                  <i class="bi bi-eye-slash"></i>
                </span>
              </div>
            </div>
          </div>

          <!-- Level Pengguna/role -->
          <div class="row mb-2">
            <label for="id_role" class="form-label fw-bold small">Level Role</label>
            <div class="col-sm-0">
              <select id="id_role" name="id_role" class="form-control" required>
                <option value="">-- Pilih Role --</option>
                @foreach ($list_role as $role)
                  <option value="{{ $role->id_role }}" data-nama_role="{{ $role->nama_role }}">
                    {{ $role->nama_role}}
                @endforeach
              </select>
            </div>
          </div>

          <!-- Departemen -->
          <div class="row mb-2">
            <label for="id_departemen" class="form-label fw-bold small">Departemen</label>
            <div class="col-sm-0">
              <select name="id_departemen" id="id_departemen" class="form-control" required>
                <option value="">-- Pilih Departemen --</option>
                @foreach ($list_departemen as $departemen)
                  <option value="{{ $departemen->id_departemen }}"
                    data-nama_departemen="{{ $departemen->nama_departemen }}">
                    {{ $departemen->nama_departemen }}
                @endforeach
              </select>
            </div>
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">