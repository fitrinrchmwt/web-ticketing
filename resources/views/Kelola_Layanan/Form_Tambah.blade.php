<div class="modal fade" id="modalFormTambahLayanan" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50%;">
        <form action="{{ route('layanan.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup">
                    </button>
                </div>
                <div class="modal-body">
                    
                        <input  type="hidden" name="id_layanan" value="{{ $kodeOtomatis }}" readonly>
                
                    <div class="row">
                        <div class="col-md-3">
                            <label>Kode Layanan</label>
                        </div>
                        <div class="col-md-9">
                            <input name="kode_layanan" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label>Nama Layanan</label>
                        </div>
                        <div class="col-md-9">
                            <input name="jenis_layanan" class="form-control" type="text" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label>Departemen</label>
                        </div>
                        <div class="col-md-9">
                            <select name="id_departemen" class="form-control" required>
                                <option value="">-- Pilih Departemen --</option>
                                @foreach ($list_departemen as $departemen)
                                    <option value="{{ $departemen->id_departemen }}" data-nama_departemen="{{ $departemen->nama_departemen }}">
                                    {{ $departemen->nama_departemen }}
                                @endforeach
                            </select>
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit"  class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

