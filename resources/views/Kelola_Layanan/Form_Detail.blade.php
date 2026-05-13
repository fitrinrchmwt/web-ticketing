<div class="modal fade" id="modalFormEdit" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50%;">
        <form>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Data</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label>ID Layanan</label>
                        </div>
                        <div class="col-md-9">
                            <input id="detail_id_layanan" class="form-control " style="background-color: #ffffffff;"
                                disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label>Kode Layanan</label>
                        </div>
                        <div class="col-md-9">
                            <input id="detail_kode_layanan" class="form-control " style="background-color: #ffffffff;"
                                disabled>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label>Nama Layanan</label>
                        </div>
                        <div class="col-md-9">
                            <input id="detail_jenis_layanan" class="form-control" type="text"
                                style="background-color: #ffffffff;" disabled>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label>Harga</label>
                        </div>
                        <div class="col-md-9">
                            <input id="detail_price" class="form-control" type="text"
                                style="background-color: #ffffffff;" disabled>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>