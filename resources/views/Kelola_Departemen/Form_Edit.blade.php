<div class="modal fade" id="modalFormEdit" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('departemen.update') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" >
                </button>
                </div>

                <div class="modal-body">
                    
                    <input type="hidden" name="id_departemen" id="edit_id_departemen" readonly>
                    
                    <div class="mb-3">
                        <label >Departemen</label>
                        <input name="nama_departemen" id="edit_nama_departemen" class="form-control" type="text" required>
                    </div>
                
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit"  class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

