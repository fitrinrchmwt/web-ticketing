<div class="modal fade" id="modalTambahPenanganan" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <form action="{{ route('ticket.penanganan') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup">
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_ticket" value="{{ $ticket->id_ticket }}">
                    {{-- Status Ticket --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <select name="id_status" id="id_status" class="form-select select2" required>
                                <option value="">-- Pilih Status --</option>
                                @foreach ($list_status as $status)
                                    <option value="{{ $status->id_status }}">
                                        {{ $status->nama_status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-2">
                            <label for="id_template">Template</label>
                        </div>
                        <div class="col-md-10">
                            <select name="id_template" id="id_template" class="form-select">
                                <option value="">-- Pilih Template --</option>
                                @foreach ($list_template as $template)
                                    <option value="{{ $template->id_template }}"
                                        data-penanganan="{{ $template->isi_template }}">
                                        {{ $template->label_template }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-2">
                            <label for="penanganan">Penanganan</label>
                        </div>
                        <div class="col-md-10">
                            <textarea rows="4" name="penanganan" id="penanganan_textarea" class="form-control"
                                required></textarea>
                        </div>
                    </div>



                    <div class="row mt-3">
                        <div class="col-md-2">
                            <label>Dokumentasi</label>
                        </div>
                        <div class="col-md-10">
                            <input type="file" name="dokumentasi" id="dokumentasi" class="form-control"
                                onchange="previewDokumentasi(this)">

                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-2"></div>
                        <div class="col-md-10">
                            <div id="preview_dokumentasi" class="mt-2"></div>
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

<script>
    //Dokumentasi Add preview
    function previewDokumentasi(input) {
        const container = $('#preview_dokumentasi');
        container.html('');

        if (!input.files || !input.files[0]) return;

        const file = input.files[0];
        const type = file.type;

        // IMAGE
        if (type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = e => {
                container.html(`
                    <img src="${e.target.result}"
                         class="img-fluid rounded shadow-sm"
                         style="max-height:200px">
                `);
            };
            reader.readAsDataURL(file);
            return;
        }

        // NON IMAGE (PDF, DOC, DLL, DLL)
        container.html(`
            <div class="alert alert-secondary d-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-text fs-4"></i>
                <span>${file.name}</span>
            </div>
        `);
    }
</script>