@extends('layout.layout_sidebar')

@section('title', 'Update Ticket')

@section('content')
    <style>
        .bg-biru {
            background-color: #54A5FA !important;
            /* biru muda*/
            color: #fff !important;
        }

        .select2-container--default .select2-selection--single {
            height: 38px !important;
            background-color: #fff !important;
            border: 1px solid #ced4da !important;
            display: flex;
            align-items: center;
        }

        .table-fixed {
            table-layout: fixed;
            width: 100%;
        }

        /* Kolom utama */
        .col-date {
            width: 140px;
            white-space: nowrap;
        }

        .col-desc {
            width: 250px;
        }

        /* Kolom sekunder */
        .col-status {
            width: 100px;
            white-space: nowrap;
        }

        .col-user {
            width: 120px;
            white-space: nowrap;
        }

        .col-action {
            width: 120px;
            white-space: nowrap;
        }


        .penanganan-cell {
            max-width: 100%;
            max-height: 200px;
            overflow-y: auto;
            overflow-x: auto;
            text-align: left;
        }

        .penanganan-cell img {
            max-width: 100%;
            height: auto;
        }
    </style>
    <div class="container-fluid">
        <div class="d-flex justify-content-start mb-3"></div>
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">Update Ticket</h4>
                <hr>
                <div class="d-flex justify-content-start mb-3"></div>
                {{-- Form Update Ticket --}}
                <form action="{{ route('ticket.store_update') }}" method="POST">
                    @csrf

                    <input type="hidden" name="id_ticket" value="{{ $ticket->id_ticket }}">

                    {{-- Ticket Referensi --}}
                    <div class="mb-3 row ">
                        <label class="col-sm-2 col-form-label">Ticket Referensi</label>

                        <div class="col-sm-8">
                            <select class="form-select" id="id_ref" name="id_ref"></select>
                        </div>

                        <div class="col-sm-2">
                            <a href="#" target="_blank" class="btn btn-warning text-white btnHistory w-100"
                                style="display: none;">
                                Lihat Detail
                            </a>
                        </div>
                    </div>

                    {{-- Subject --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Subject</label>
                        <div class="col-sm-10">
                            <select class="form-select select2-subject" name="id_subject">
                                <option value="">Pilih Template Subject</option>
                                @foreach ($list_subject as $subject)
                                    <option value="{{ $subject->id_subject }}">
                                        {{ $subject->isi_subject }}
                                    </option>
                                @endforeach
                            </select>

                            <textarea class="form-control mt-2" name="subject" rows="4"
                                required>{{ old('isi_subject', $ticket->subject) }}</textarea>
                        </div>
                    </div>

                    {{-- Jenis --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" name="jenis">Jenis</label>
                        <div class="col-sm-10">
                            <select name="jenis" id="jenis" class="form-select" required>
                                <option>Pilih Jenis</option>
                                <option value="1">Multi Case</option>
                                <option value="0">Single Case</option>
                            </select>
                        </div>
                    </div>



                    {{-- Kategori --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-10">
                            <select name="id_kategori" class="form-select select2-kategori" required>
                                <option>Pilih Kategori</option>
                                @foreach ($list_kategori as $kategori)
                                    <option value="{{ $kategori->id_kategori }}" {{ $ticket->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Nama Pelanggan --}}
                    <div id="aturan">
                    </div>


                    <hr>
                    <h5 class="mb-3">Gangguan</h5>

                    {{-- Tanggal & Jam --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="tanggal" value="{{ $tanggal }}">
                        </div>
                        <label class="col-sm-2 col-form-label">Jam</label>
                        <div class="col-sm-4">
                            <input type="time" class="form-control" name="jam" value="{{ $jam}}">
                        </div>
                    </div>

                    {{-- Tanggal Selesai & Jam --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Tanggal Selesai</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" value="{{ $tanggal_selesai ?? '' }}">
                        </div>
                        <label class="col-sm-2 col-form-label">Jam</label>
                        <div class="col-sm-4">
                            <input type="time" class="form-control" value="{{ $jam_selesai ?? '' }}">
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="pilih_lokasi" class="form-label">Lokasi</label>
                        </div>
                        <div class="col-md-5">
                            <select id="pilih_lokasi" class="form-select" name="tipe_lokasi">
                                <option value="">Pilih Lokasi Gangguan</option>
                                <option value="alamat">Alamat</option>
                                <option value="alamat_koordinat">Alamat & Koordinat</option>
                            </select>
                        </div>
                    </div>

                    {{-- Input Alamat --}}
                    <div class="lokasi_gangguan" hidden>
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label>Alamat</label>
                            </div>
                            <div class="col-md-5">
                                <textarea class="form-control" rows="3" id="alamat" name="alamat"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Input Koordinat + Map --}}
                    <div class="lokasi_gangguan2" hidden>
                        <div class="row mb-3">
                            <div class="col-md-2 text-end"></div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <div id="maps-input" style="height: 400px; border: 1px solid #ccc; border-radius: 8px;">
                                    </div>
                                    <input name="latitude" id="latitude" class="form-control mt-2" type="text"
                                        placeholder="Latitude" readonly>
                                    <input name="longitude" id="longitude" class="form-control mt-2" type="text"
                                        placeholder="Longitude" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Deskripsi</label>
                        <div class="col-sm-10">
                            <div class="mb-2">
                                <select id="pilih_deskripsi" name="id_deskripsi" class="form-select">
                                    <option>Pilih Template Deskripsi</option>
                                    @foreach ($list_deskripsi as $deskripsi)
                                        <option value="{{ $deskripsi->id_deskripsi }}" {{ $ticket->id_deskripsi == $deskripsi->id_deskripsi ? 'selected' : '' }}
                                            data-label="{{ $deskripsi->deskripsi }}">
                                            {{ $deskripsi->label_deskripsi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- id untuk simpan foto sementara -->
                            <input type="hidden" id="draft_id" name="draft_id" value="">

                            <!-- <textarea class="form-control" rows="4"></textarea> -->
                            <div class="col-md-9">
                                <textarea name="deskripsi" id="deskripsi_text" class="form-control mt-2" rows="4"
                                    placeholder="Tulis deskripsi manual" required>{{ $ticket->deskripsi }}</textarea>

                            </div>
                        </div>
                    </div>

                    {{-- Dispatcher --}}
                    <div class="mb-4 row mt-3">
                        <label class="col-sm-2 col-form-label">Dispatcher</label>
                        <div class="col-sm-10">
                            <select class="form-select select2" name="dispatcher[]" id="dispatcher" multiple>
                                <option>Pilih SPV</option>
                                @foreach ($list_spv as $spv)
                                    <option value="{{ $spv->id_pengguna }}" {{ in_array($spv->id_pengguna, $selectedDispatchers) ? 'selected' : '' }}>{{ $spv->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    {{-- Bookmark & Downtime --}}
                    <div class="mb-3 row">
                        <div class="col-sm-10 offset-sm-2">
                            <!-- Checkbox 1 -->
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="bookmark" id="bookmark" value="1" {{ $ticket->bookmark ? 'checked' : '' }}>
                                <label class="form-check-label" for="bookmark">Bookmark</label>
                            </div>

                            <!-- Checkbox 2 -->
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="downtime" id="downtime" value="1" {{ $ticket->downtime ? 'checked' : '' }}>
                                <label class="form-check-label" for="downtime">Downtime</label>
                            </div>
                        </div>
                    </div>


                    <!-- History Jadwal -->
                    <div class="mb-3 mt-4">
                        <hr class="mt-0 mb-3">
                        <h4 class="mb-0">History Jadwal</h4>

                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-primary btn-detail-aksi" data-style="expand-right"
                                data-bs-toggle="modal" data-bs-target="#modalTambahJadwal"
                                style="{{ $closed ? 'display: none' : '' }};">
                                <span class="ladda-label">Tambah</span>
                            </button>
                        </div>
                    </div>


                    <!-- History jadwal -->
                    <table id="tableData" class="table table-bordered table-striped text-center" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th class="th-merah">Tanggal Jadwal</th>
                                <th class="th-merah">PIC Teknis</th>
                                <th class="th-merah">Catatan</th>
                                <th class="th-merah">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($list_jadwal as $key => $jadwal)
                                <tr>
                                    <td>{{ $jadwal->jadwal }}</td>
                                    <td>{{ $jadwal->nama_pic }}</td>
                                    <td>{{ $jadwal->catatan }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Tombol Detail -->
                                            <button type="button" class="btn btn-warning btn-sm text-white mb-2"
                                                data-bs-toggle="modal" data-bs-target="#modalDetailJadwal"
                                                data-jadwal="{{ $jadwal->jadwal }}" data-pengguna="{{ $jadwal->nama_pic }}"
                                                data-updated_by="{{ $jadwal->nama_updated_by }}"
                                                data-catatan="{{ $jadwal->catatan }}">
                                                Detail
                                            </button>

                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-success btn-sm text-white mb-2"
                                                data-bs-toggle="modal" data-bs-target="#modalEditJadwal"
                                                data-edit_id_jadwal="{{ $jadwal->id_jadwal }}"
                                                data-edit_id_ticket2="{{ $jadwal->id_ticket }}"
                                                data-edit_jadwal="{{ $jadwal->jadwal }}"
                                                data-edit_id_pengguna="{{ $jadwal->id_pengguna }}"
                                                data-edit_catatan="{{ $jadwal->catatan }}"
                                                style="{{ $closed ? 'display: none' : '' }};">
                                                Edit
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Belum ada Jadwal</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>


                    <!-- History Penanganan -->
                    <div class="mb-3 mt-4">
                        <hr class="mt-0 mb-3">
                        <h4 class="mb-0">History Penanganan</h4>

                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-primary btn-tambah-penanganan" data-style="expand-right"
                                data-bs-toggle="modal" data-bs-target="#modalTambahPenanganan"
                                style="{{ $closed ? 'display: none' : '' }};">
                                <span class="ladda-label">Tambah</span>
                            </button>
                        </div>
                    </div>


                    <div class="table-responsive">
                        <table id="tableData" class="table table-bordered table-striped text-center table-fixed"
                            width="100%" cellspacing="0">
                            <thead class="align-middle">
                                <tr>
                                    <th class="th-merah text-center col-date">Tanggal Proses</th>
                                    <th class="th-merah text-center col-desc">Penanganan</th>
                                    <th class="th-merah text-center col-status">Status</th>
                                    <th class="th-merah text-center col-user">User</th>
                                    <th class="th-merah text-center col-action">Aksi</th>

                                </tr>

                            </thead>

                            <tbody>
                                @forelse ($list_penanganan as $key => $penanganan)
                                    <tr>
                                        <td>{{ $penanganan->tanggal_proses }}</td>
                                        <td>
                                            <div class="penanganan-cell">
                                                {!! $penanganan->penanganan !!}
                                            </div>
                                        </td>


                                        <td>{{ $penanganan->nama_status }}</td>
                                        <td>{{ $penanganan->nama }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-1">
                                                <!-- Tombol Detail -->
                                                <button type="button" class="btn btn-warning btn-sm text-white mb-2"
                                                    data-bs-toggle="modal" data-bs-target="#modalDetailPenanganan"
                                                    data-tanggal="{{ $penanganan->created_at_formatted }}"
                                                    data-penanganan="{!! htmlspecialchars($penanganan->penanganan, ENT_QUOTES) !!}"
                                                    data-status="{{ $penanganan->nama_status }}"
                                                    data-user="{{ $penanganan->nama }}"
                                                    data-dokumentasi="{{ $penanganan->dokumentasi }}">
                                                    Detail
                                                </button>

                                                <!-- Tombol Edit -->
                                                <button type="button" class="btn btn-success btn-sm text-white mb-2"
                                                    data-bs-toggle="modal" data-bs-target="#modalEditPenanganan"
                                                    data-edit_id_status="{{ $penanganan->id_status }}"
                                                    data-edit_penanganan="{!! htmlspecialchars($penanganan->penanganan, ENT_QUOTES) !!}"
                                                    data-edit_id_penanganan="{{ $penanganan->id_penanganan }}"
                                                    data-edit_id_ticket="{{ $penanganan->id_ticket }}"
                                                    data-dokumentasi="{{ $penanganan->dokumentasi }}"
                                                    style="{{ $closed ? 'display: none' : '' }};">
                                                    Edit
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">Belum ada Penanganan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </script>
                    </div>


            </div>
            {{-- Tombol --}}
            <div class="mb-3 row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary"
                        style="{{ $closed ? 'display: none' : '' }};">Simpan</button>
                    <a href="{{ route('ticket.dashboard') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>

            </form>


            <!-- Modal Jadwal -->
            @include('Ticket.History_Jadwal.tambah_history_jadwal')
            @include('Ticket.History_Jadwal.detail_jadwal')
            @include('Ticket.History_Jadwal.edit_history_jadwal')

            <!-- Modal Penanganan -->
            @include('Ticket.History_Penanganan.tambah_history_penanganan')
            @include('Ticket.History_Penanganan.detail_penanganan')
            @include('Ticket.History_Penanganan.edit_history_penanganan')



@endsection


        @section('script')

            <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
            <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">


            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

            <script>
                //  GLOBAL DATA
                window.AppData = {
                    baseUrl: "{{ url('') }}",
                    assetUrl: "{{ asset('') }}",
                    id_ref: "{{ $ticket->id_ref }}",
                    hash_id: "{{ $ref_text->hash_id ?? '' }}",
                    ref_text: "{{ $ref_text->text ?? ''}}",
                    ticketJenis: "{{ $ticket->jenis }}",
                    status: "{{ $ticket->id_status }}",
                    customers: @json($customers),
                    alamat: "{{ $ticket->alamat }}",
                    latitude: "{{ $ticket->latitude }}",
                    longitude: "{{ $ticket->longitude }}"
                };
            </script>

            @if ($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Update Ticket',
                        html: `
                            <ul style="text-align:left;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        `,
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif


            <script>
                // APP NAMESPACE
                const App = {

                    map: null,
                    marker: null,

                    init() {
                        this.initSelect2();
                        this.initEditors();
                        this.initModals();
                        this.initMapSection();
                        this.initTicketRef();
                        this.initTicketForm();
                    },

                    //  SELECT2
                    initSelect2() {
                        $('.select2-subject, .select2-kategori, #jenis').select2({
                            width: '100%',
                            allowClear: true
                        });

                        $('#dispatcher').select2({
                            placeholder: '-- Pilih SPV --',
                            allowClear: true,
                            width: '100%'
                        });

                        $('#spCodeId').select2({ width: '100%' });
                    },

                    //  SUMMERNOTE
                    initSummernote(selector, type) {
                        if (!$(selector).next('.note-editor').length) {
                            $(selector).summernote({
                                height: 250,
                                toolbar: [
                                    ['style'],
                                    ['font', ['bold', 'italic', 'underline', 'clear']],
                                    ['fontname', ['fontname']],
                                    ['color', ['color']],
                                    ['para', ['ul', 'ol', 'paragraph']],
                                    ['table'],
                                    ['insert', ['link', 'picture']],
                                    ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                                ],
                                callbacks: {
                                    onImageUpload: function (files) {
                                        uploadImage(files[0]);
                                    },
                                },
                            });

                            function uploadImage(file) {
                                let data = new FormData();
                                data.append("image", file);
                                data.append("_token", "{{ csrf_token() }}");
                                data.append('type', type ?? 'ticket');
                                data.append('draft_id', $('#draft_id').val());

                                $.ajax({
                                    url: AppData.baseUrl + "/upload/summernote",
                                    method: "POST",
                                    data: data,
                                    processData: false,
                                    contentType: false,
                                    success: function (res) {
                                        $(selector).summernote('insertImage', res.url);
                                    },
                                    error: function (xhr) {
                                        let msg = 'Terjadi kesalahan';

                                        if (xhr.responseJSON) {
                                            if (xhr.responseJSON.errors) {
                                                msg = Object.values(xhr.responseJSON.errors)
                                                    .map(err => err.join(', '))
                                                    .join('\n');
                                            } else if (xhr.responseJSON.message) {
                                                msg = xhr.responseJSON.message;
                                            }
                                        }

                                        alert(msg);
                                    }

                                });
                            }

                        }
                    },

                    initEditors() {
                        this.initSummernote('#deskripsi_text', 'ticket');
                        this.initSummernote('#penanganan_textarea', 'penanganan');
                        this.initSummernote('#edit_penanganan', 'penanganan');

                        $('#pilih_deskripsi').on('change', function () {
                            $('#deskripsi_text').summernote(
                                'code',
                                $(this).find(':selected').data('label') || ''
                            );
                        });

                        if (!$('#draft_id').val()) {
                            $('#draft_id').val(crypto.randomUUID());
                        }

                    },

                    //  MODAL HANDLER
                    initModals() {
                        //penanganan
                        this.bindDetailModal();
                        this.bindEditModal();
                        this.bindAddModal();

                        //jadwal
                        this.bindDetailJadwalModal();
                        this.bindEditJadwalModal();
                    },

                    renderDokumentasi(container, file) {
                        const el = document.getElementById(container);
                        el.innerHTML = '';

                        if (!file) {
                            el.innerHTML = '<em class="text-muted">Tidak ada dokumentasi</em>';
                            return;
                        }

                        const url = `${AppData.assetUrl}/storage/${file}`;
                        const ext = file.split('.').pop().toLowerCase();

                        if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                            el.innerHTML = `
                                <a href="${url}" target="_blank">
                                    <img src="${url}" class="img-fluid rounded shadow-sm" style="max-width:200px">
                                </a>`;
                        } else {
                            el.innerHTML = `
                                <a href="${url}" target="_blank" class="btn btn-sm btn-secondary">
                                    Download File
                                </a>`;                              
                        }
                    },

                    bindDetailModal() {
                        const modal = document.getElementById('modalDetailPenanganan');
                        if (!modal) return;

                        modal.addEventListener('show.bs.modal', e => {
                            const btn = e.relatedTarget;

                            $('#detailTanggal').text(btn.dataset.tanggal);
                            $('#detailPenanganan').html(btn.dataset.penanganan);
                            $('#detailStatus').text(btn.dataset.status);
                            $('#detailUser').text(btn.dataset.user);

                            this.renderDokumentasi('detailDokumentasi', btn.dataset.dokumentasi);
                        });
                    },

                    bindEditModal() {
                        const modal = document.getElementById('modalEditPenanganan');
                        if (!modal) return;

                        function uploadImage(file) {
                            let data = new FormData();
                            data.append("image", file);
                            data.append("_token", "{{ csrf_token() }}");
                            data.append("type", "penanganan");
                            data.append('draft_id', $('#draft_id').val());

                            $.ajax({
                                url: AppData.baseUrl + "/upload/summernote",
                                method: "POST",
                                data: data,
                                processData: false,
                                contentType: false,
                                success: function (res) {
                                    $('#edit_penanganan').summernote('insertImage', res.url);
                                },
                                error: function (xhr) {
                                    let msg = 'Terjadi kesalahan';

                                    if (xhr.responseJSON) {
                                        if (xhr.responseJSON.errors) {
                                            msg = Object.values(xhr.responseJSON.errors)
                                                .map(err => err.join(', '))
                                                .join('\n');
                                        } else if (xhr.responseJSON.message) {
                                            msg = xhr.responseJSON.message;
                                        }
                                    }

                                    alert(msg);
                                }
                            });
                        }

                        $(document).on('change', '#id_template', function () {
                            console.log('berubah');

                            const html = $(this).find(':selected').data('edit_penanganan') || '';
                            $('#edit_penanganan').summernote('code', html);
                        });


                        modal.addEventListener('shown.bs.modal', () => {
                            this.initSummernote('#edit_penanganan');
                        });

                        modal.addEventListener('show.bs.modal', e => {
                            const btn = e.relatedTarget;

                            $('#edit_id_penanganan').val(btn.dataset.edit_id_penanganan);
                            $('#edit_id_ticket').val(btn.dataset.edit_id_ticket);
                            $('#edit_id_status').val(btn.dataset.edit_id_status);
                            $('#id_template').val('').trigger('change');
                            $('#edit_penanganan').summernote('code', btn.dataset.edit_penanganan);

                            this.renderDokumentasi('preview_dokumentasi_edit', btn.dataset.dokumentasi);
                        });
                    },



                    bindAddModal() {
                        const modal = document.getElementById('modalTambahPenanganan');
                        if (!modal) return;


                        function uploadImage(file) {
                            let data = new FormData();
                            data.append("image", file);
                            data.append("_token", "{{ csrf_token() }}");
                            data.append("type", "penanganan");
                            data.append('draft_id', $('#draft_id').val());

                            $.ajax({
                                url: AppData.baseUrl + "/upload/summernote",
                                method: "POST",
                                data: data,
                                processData: false,
                                contentType: false,
                                success: function (res) {
                                    $('#penanganan_textarea').summernote('insertImage', res.url);
                                },
                                error: function (xhr) {
                                    let msg = 'Terjadi kesalahan';

                                    if (xhr.responseJSON) {
                                        if (xhr.responseJSON.errors) {
                                            msg = Object.values(xhr.responseJSON.errors)
                                                .map(err => err.join(', '))
                                                .join('\n');
                                        } else if (xhr.responseJSON.message) {
                                            msg = xhr.responseJSON.message;
                                        }
                                    }

                                    alert(msg);
                                }
                            });
                        }


                        $('#id_template')
                            .off('change')
                            .on('change', function () {
                                console.log('berubah');
                                $('#penanganan_textarea').summernote(
                                    'code',
                                    $(this).find(':selected').data('penanganan') || ''
                                );
                            });

                        modal.addEventListener('shown.bs.modal', () => {
                            this.initSummernote('#penanganan_textarea');
                        });


                        modal.addEventListener('show.bs.modal', () => {
                            $('#id_status').val(AppData.status).trigger('change');
                            $('#id_template').val('').trigger('change');
                            $('#penanganan_textarea').summernote('code', '');
                            $('#dokumentasi').val('');
                            $('#preview_dokumentasi').html('');
                        });

                    },



                    bindDetailJadwalModal() {
                        const modalDetailJadwal = document.getElementById('modalDetailJadwal');

                        modalDetailJadwal.addEventListener('show.bs.modal', function (event) {
                            const button = event.relatedTarget;

                            document.getElementById('detailjadwal').textContent =
                                button.getAttribute('data-jadwal');

                            document.getElementById('detailpengguna').innerHTML =
                                button.getAttribute('data-pengguna');

                            document.getElementById('detailcatatan').textContent =
                                button.getAttribute('data-catatan');

                            document.getElementById('detailupdated_by').textContent =
                                button.getAttribute('data-updated_by');
                        });
                    },


                    bindEditJadwalModal() {
                        const modalEdit = document.getElementById('modalEditJadwal');

                        modalEdit.addEventListener('show.bs.modal', function (event) {
                            const button = event.relatedTarget;

                            document.getElementById('edit_id_jadwal').value = button.getAttribute('data-edit_id_jadwal');
                            document.getElementById('edit_id_ticket2').value = button.getAttribute('data-edit_id_ticket2');
                            document.getElementById('edit_jadwal').value = button.getAttribute('data-edit_jadwal');
                            document.getElementById('edit_id_pengguna').value = button.getAttribute('data-edit_id_pengguna');
                            document.getElementById('edit_catatan').value = button.getAttribute('data-edit_catatan');
                        });
                    },


                    // MAP
                    initMap(lat = -7.797068, lng = 110.370529) {
                        if (this.map) {
                            this.map.invalidateSize();
                            return;
                        }

                        this.map = L.map('maps-input').setView([lat, lng], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png')
                            .addTo(this.map);

                        this.marker = L.marker([lat, lng]).addTo(this.map);

                        this.map.on('click', e => {
                            const { lat, lng } = e.latlng;
                            $('#latitude').val(lat.toFixed(6));
                            $('#longitude').val(lng.toFixed(6));
                            this.marker.setLatLng(e.latlng);
                        });
                    },

                    initMapSection() {
                        $('#pilih_lokasi').on('change', e => {
                            $('.lokasi_gangguan, .lokasi_gangguan2').prop('hidden', true);

                            if (e.target.value === 'alamat') {
                                $('.lokasi_gangguan').prop('hidden', false);
                            }

                            if (e.target.value === 'alamat_koordinat') {
                                $('.lokasi_gangguan, .lokasi_gangguan2').prop('hidden', false);
                                this.initMap(
                                    AppData.latitude || undefined,
                                    AppData.longitude || undefined
                                );
                            }
                        });

                        if (AppData.latitude && AppData.longitude) {
                            $('#pilih_lokasi').val('alamat_koordinat').trigger('change');
                            $('#latitude').val(AppData.latitude);
                            $('#longitude').val(AppData.longitude);
                            $('#alamat').val(AppData.alamat || '');
                        } else if (AppData.alamat) {
                            $('#pilih_lokasi').val('alamat').trigger('change');
                            $('#alamat').val(AppData.alamat);
                        }
                    },

                    // TICKET FORM
                    initTicketRef() {
                        this.bindTicketRef();

                        if (AppData.id_ref) {
                            const opt = new Option(AppData.ref_text, AppData.id_ref, true, true);
                            $('#id_ref').append(opt).trigger('change');

                            // Trigger change
                            $('#id_ref').trigger({
                                type: 'select2:select',
                                params: {
                                    data: {
                                        id: AppData.id_ref,
                                        hash_id: AppData.hash_id
                                    }
                                }
                            });
                        }
                    },
                    bindTicketRef() {
                        $('#id_ref')
                            .select2({
                                placeholder: '-- Pilih Ticket Referensi --',
                                allowClear: true,
                                width: '100%',
                                ajax: {
                                    delay: 300,
                                    method: 'POST',
                                    url: "{{ route('ticket.ticketrefs') }}",
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: params => ({
                                        search: params.term || '',
                                        page: params.page || 1
                                    }),
                                    processResults: (data, params) => {

                                        let keyword = params.term ? params.term.toLowerCase() : '';
                                        let kw = String(keyword || '').toLowerCase();

                                        let filtered = data.data
                                            .filter(item =>
                                                !kw ||
                                                String(item.id || '').toLowerCase().includes(kw) ||
                                                String(item.text || '').toLowerCase().includes(kw)
                                            )
                                            .slice(0, 20);


                                        return {
                                            results: filtered.map(item => ({
                                                id: item.id_ticket,
                                                hash_id: item.hash_id,
                                                text: item.text,
                                                id_kategori: item.id_kategori
                                            })),
                                            // pagination: { more: data.current_page < data.last_page }
                                        }
                                    }
                                }

                            }).on('select2:select', function (e) {
                                let selectedId = e.params.data.hash_id;
                                let detailUrl = "{{ url('history-ticket') }}/" + selectedId;
                                $('.btnHistory').attr('href', detailUrl).show();
                                $('#id_kategori').val(e.params.data.id_kategori).trigger('change');
                            });
                    }, initTicketForm() {
                        $('#jenis').val(String(AppData.ticketJenis)).trigger('change'); $('#jenis').on('change', e => {
                            e.target.value === '1'
                                ? Customer.initMulti()
                                : Customer.initSingle();
                        });

                        AppData.ticketJenis == '1'
                            ? Customer.initMulti(true)
                            : Customer.initSingle(true);
                    }
                };

               
                // CUSTOMER HANDLER
                const Customer = {

                    initSingle(isEdit = false) {
                        this.renderSingle();
                        this.bindSingle();

                        if (isEdit && AppData.customers.length) {
                            const c = AppData.customers[0];
                            const text = `${c.custNumber} - ${c.custName}`;
                            const opt = new Option(text, c.custNumber, true, true);
                            $('#custNumber').append(opt).trigger('change');
                            $('#spCodeId').append(new Option(c.spCode, c.spCodeId, true, true)).trigger('change');
                            $('#custPhone').val(c.custPhone);
                        }
                    },

                    initMulti(isEdit = false) {
                        this.renderMulti();

                        if (isEdit && AppData.customers.length) {
                            $('#customer').empty();
                            AppData.customers.forEach((c) => {
                                const $row = $(this.multiRow());
                                $('#customer').append($row);

                                //INIT SELECT2
                                this.initSelect2Row($row);

                                //SET DATA
                                const opt = new Option(
                                    `${c.custNumber} - ${c.custName}`,
                                    c.custNumber,
                                    true,
                                    true
                                );

                                $row.find('.pelanggan-gamas').append(opt).trigger('change');
                                $row.find('.nomor-gamas').val(c.custPhone);
                            });
                        } else {
                            const $row = $(this.multiRow());
                            $('#customer').append($row);
                            this.initSelect2Row($row);
                        }

                        this.bindMultiButtons();
                        this.updateMultiButtons();

                    },



                    renderSingle() {
                        $('#aturan').html(`
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Pelanggan</label>
                                <div class="col-sm-10">
                                    <select id="custNumber" name="custNumber" class="form-select"></select>
                                </div>
                            </div>
                            {{-- Layanan --}}
                            <div class='mb-3 row'>
                                <label class='col-sm-2 col-form-label'>Layanan</label>
                                <div class='col-sm-10'>
                                    <select name='spCodeId' id='spCodeId' class='form-select'>
                                        <option value=''>-- Layanan --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Nomor Telepon</label>
                                <div class="col-sm-10">
                                    <input id="custPhone" name="custPhone" placeholder='-- Nomor Telepon --' class="form-control">
                                </div>
                            </div>
                            `);
                    },

                    renderMulti() {
                        if ($('#customer').length) return;

                        $('#aturan').html(`
                            <div id="customer"></div>
                            `);
                    },


                    multiRow() {
                        return `
                            <div class="list_cust">
                                <hr>

                                <div class='row mb-2'>
                                    <div class='col-md-2'>
                                        <label>Nama Pelanggan</label>
                                    </div>
                                    <div class='col-md-5'>
                                        <select name='custNumber[]'
                                            class='form-select pelanggan-gamas'
                                            required></select>
                                    </div>
                                </div>

                                <div class='row mb-2'>
                                    <div class='col-md-2'>
                                        <label>Nomor Telepon</label>
                                    </div>
                                    <div class='col-md-5'>
                                        <input class='form-control nomor-gamas' placeholder='-- Nomor Telepon --' name='custPhone[]'>
                                    </div>

                                    <div class='col-md-2 btn-wrapper d-flex gap-2'>
                                        <button type='button' class='btn btn-danger remove-list'>
                                            <i class='bi bi-dash-lg'></i>
                                        </button>
                                    </div>
                                </div>

                                <input type='hidden' name='spCodeId' value='gamas'>
                            </div>
                        `;
                    },

                    updateMultiButtons() {
                        const rows = $('#customer .list_cust');

                        // hapus semua tombol tambah
                        rows.find('.add-list').remove();

                        if (!rows.length) return;

                        // pasang tombol tambah di baris terakhir
                        rows.last().find('.btn-wrapper').append(`
                            <button type="button" class="btn btn-primary add-list">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        `);
                    },



                    bindSingle() {
                        $('#custNumber').select2({
                            placeholder: "-- Pilih pelanggan --",
                            ajax: {
                                delay: 300,
                                url: "{{ route('ticket.customers') }}",
                                processResults: d => ({
                                    results: d.data.map(i => ({
                                        id: i.custNumber,
                                        text: `${i.custNumber} - ${i.custName}`,
                                        spCode: i.spCode,
                                        spCodeId: i.spCodeId,
                                        phone: i.custPhone,
                                        alamat: i.custAddress,
                                        latitude: i.custLatitude,
                                        longitude: i.custLongitude
                                    }))
                                })
                            }
                        }).on('select2:select', e => {
                            d = e.params.data;
                            $('#spCodeId').empty().append(new Option(e.params.data.spCode, e.params.data.spCodeId, true,
                                true)).trigger('change');
                            $('#spCodeId').val(e.params.data.spCodeId);
                            $('#custPhone').val(e.params.data.phone);

                            const pilihLokasi = document.getElementById('pilih_lokasi');
                            if (d.latitude && d.longitude) {
                                pilihLokasi.value = 'alamat_koordinat';
                                pilihLokasi.dispatchEvent(new Event('change'));
                                $('#alamat').val(d.alamat);
                                $('#latitude').val(d.latitude);
                                $('#longitude').val(d.longitude);
                            } else {
                                pilihLokasi.value = 'alamat';
                                pilihLokasi.dispatchEvent(new Event('change'));
                                $('#alamat').val(d.alamat);
                                $('#latitude').val('');
                                $('#longitude').val('');
                            }
                        });
                    },

                    initSelect2Row($row) {
                        $row.find('.pelanggan-gamas').select2({
                            placeholder: "-- Pilih pelanggan --",
                            ajax: {
                                delay: 300,
                                url: "{{ route('ticket.customers') }}",
                                processResults: d => ({
                                    results: d.data.map(i => ({
                                        id: i.custNumber,
                                        text: `${i.custNumber} - ${i.custName}`,
                                        phone: i.custPhone
                                    }))
                                })
                            }
                        }).on('select2:select', e => {
                            const d = e.params.data;
                            $row.find('.nomor-gamas').val(d.phone);
                        });
                    },


                    bindMultiButtons() {
                        $(document)
                            .off('click.multi')

                            .on('click.multi', '.add-list', e => {
                                e.preventDefault();
                                const $row = $(this.multiRow());
                                $('#customer').append($row);
                                this.initSelect2Row($row);
                                this.updateMultiButtons(); // WAJIB
                            })

                            .on('click.multi', '.remove-list', e => {
                                e.preventDefault();

                                if ($('.list_cust').length === 1) {
                                    alert('Minimal harus ada 1 baris');
                                    return;
                                }

                                $(e.target).closest('.list_cust').remove();
                                this.updateMultiButtons();
                            });
                    }


                };

                // BOOTSTRAP
                $(document).ready(() => App.init());
            </script>

        @endsection