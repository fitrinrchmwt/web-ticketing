<div class="modal fade" id="modalFormEditDeskripsi" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50%;">
        <form action="{{ route('deskripsi.update') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup" ></button>
                </div>
                <div class="modal-body">
                    <input  type="hidden" name="id_deskripsi" id="edit_id_deskripsi" value="{{ $kodeOtomatis }}" readonly>
                    <div class="row">
                        <div class="col-md-2">
                            <label>Label</label>
                        </div>
                        <div class="col-md-10">
                            <input name="label_deskripsi" id="edit_label_deskripsi" class="form-control form_valid" type="text" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-2">
                            <label>Deskripsi</label>
                        </div>
                        <div class="col-md-10">
                            <textarea rows="3" name="deskripsi" id="edit_deskripsi" class="form-control" required></textarea>
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

