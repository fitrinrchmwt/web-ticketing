<div class="modal fade" id="modalFormEdit" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('status.update') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" ></button>
                </div>
                <div class="modal-body">
                    
                    <input type="hidden" name="id_status" id="edit_id_status" readonly>
                    
                    <div class="mb-3">
                        <label >status</label>
                        <input name="nama_status" id="edit_nama_status" class="form-control" type="text" required>
                    </div>
                    <div class="mb-3">
                        <label >Urutan</label>
                        <input name="urutan" id="edit_urutan" class="form-control" type="text">
                    </div>
                
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit"  class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

