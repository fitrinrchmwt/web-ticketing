<div class="modal fade" id="modalFormTambahSub" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('subject.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup">
                    </button>
                </div>
                <div class="modal-body">
                   
                        <input type="hidden" name="id_subject" value="{{ $kodeOtomatis }}" readonly>
            
                    <div class="mb-3">
                        <label>subject</label>
                        <input name="isi_subject" id="isi_subject" class="form-control" type="text" value="" required>
                    </div>
                
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit"  class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>