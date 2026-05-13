<div class="modal fade" id="modalPesan" tabindex="-1" aria-labelledby="modalPesanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPesanLabel">Kirim Broadcast</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('broadcast.store') }}">
                @csrf

                <div class="modal-body">

                    <!-- hidden cust number -->
                    <div id="custNumberContainer"></div>

                    <!-- pelanggan -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Pelanggan</label>
                        <div class="col-sm-9">

                            <div class="border rounded" style="max-height: 180px; overflow-y: auto;">
                                <table class="table table-sm table-bordered mb-0">
                                    <tbody id="listPelanggan">
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">
                                                Belum ada pelanggan dipilih
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                    <!-- tanggal -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Tanggal Kirim</label>
                        <div class="col-sm-9">
                            <input type="datetime-local"
                                   name="schedule_at"
                                   class="form-control"
                                   value="{{ now()->format('Y-m-d\TH:i') }}">
                        </div>
                    </div>

                    <!-- tamplate -->
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Template</label>
                        <div class="col-sm-9">
                            <select name="id_wa_tamplate"
                                    id="templateSelect"
                                    class="form-select"
                                    required>
                                <option value="">Pilih Template</option>
                                @foreach ($templates as $tpl)
                                    <option value="{{ $tpl->id_wa_tamplate }}"
                                            data-content="{{ e($tpl->content) }}">
                                        {{ $tpl->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- isi pesan -->
                    <div class="row">
                        <label class="col-sm-3 col-form-label">Isi Pesan</label>
                        <div class="col-sm-9">
                            <textarea id="isiPesan" class="form-control bg-light" rows="6" readonly placeholder="Pilih template terlebih dahulu"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
