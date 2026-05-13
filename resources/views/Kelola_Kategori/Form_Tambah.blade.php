<div class="modal fade" id="modalFormTambah" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50%;">
        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup">
                    </button>
                </div>
                <div class="modal-body">
                    <input  type="hidden" name="id_kategori" value="{{ $kodeOtomatis }}" readonly> 

                    <div class="row" id="formTambahKategori">
                        <div class="col-md-2">
                            <label for="nama_kategori" class="form-label">Kategori</label>
                        </div>
                        <div class="col-md-10">
                            <input name="nama_kategori" class="form-control" type="text" required>
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

