<div class="modal fade" id="modalTambahJadwal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50%;">
        <form action="{{ route('ticket.jadwal') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup">
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_ticket" value="{{ $ticket->id_ticket }}">
                    
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Tanggal Jadwal</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="jadwal" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-2">
                            <label for="id_pengguna">PIC Teknis</label>
                        </div>
                        <div class="col-md-10">
                            <select name="id_pengguna" id="id_pengguna" class="form-select">
                                <option value="">-- Pilih PIC --</option>
                                @foreach ($list_pengguna as $pengguna)
                                    <option value="{{ $pengguna->id_pengguna }}">
                                        {{ $pengguna->nama}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-2">
                            <label for="catatan">Catatan</label>
                        </div>
                        <div class="col-md-10">
                            <textarea rows="3" name="catatan" id="catatan" class="form-control"
                                required></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>