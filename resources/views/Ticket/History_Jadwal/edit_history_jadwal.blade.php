<div class="modal fade" id="modalEditJadwal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 50%;">
        <form action="{{ route('ticket.edit_jadwal') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Jadwal</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_jadwal" id="edit_id_jadwal">
                    <input type="hidden" name="id_ticket" id="edit_id_ticket2">

                    <!-- Tanggal Jadwal -->
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Tanggal Jadwal</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="jadwal" id="edit_jadwal" required>
                        </div>
                    </div>

                    <!-- PIC Teknis -->
                    <div class="row mb-3">
                        <label class="col-md-2 col-form-label" for="edit_id_pengguna">PIC Teknis</label>
                        <div class="col-md-10">
                            <select name="id_pengguna" id="edit_id_pengguna" class="form-select" required>
                                <option value="">-- Pilih PIC --</option>
                                @foreach ($list_pengguna as $pengguna)
                                    <option value="{{ $pengguna->id_pengguna }}">
                                        {{ $pengguna->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="row">
                        <label class="col-md-2 col-form-label" for="edit_catatan">Catatan</label>
                        <div class="col-md-10">
                            <textarea rows="3" name="catatan" id="edit_catatan" class="form-control" required></textarea>
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
