@extends('layout.layout_sidebar')

@section('title', 'Create Ticket')

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

        /* Wrapper pagination */
        .pagination {
            margin: 0;
        }

        /* Semua tombol */
        .pagination .page-link {
            font-size: 13px;
            padding: 4px 10px;
            color: #333;
            background-color: #fff;
            border: 1px solid #dcdcdc;
            border-radius: 2px;
            transition: all 0.15s ease-in-out;
        }

        /* Hover */
        .pagination .page-link:hover {
            background-color: #e9e9e9;
            color: #000;
        }

        /* Active page */
        .pagination .page-item.active .page-link {
            background-color: #9B2244;
            /* abu DataTables */
            border-color: #6c757d;
            color: #fff;
            font-weight: 600;
            pointer-events: none;
        }

        /* Disabled */
        .pagination .page-item.disabled .page-link {
            color: #aaa;
            background-color: #f8f9fa;
            border-color: #e0e0e0;
            cursor: not-allowed;
        }

        /* Previous / Next */
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            font-weight: 500;
        }

        .table th {
            text-align: center;
            /* horizontal tengah */
            vertical-align: middle;
            /* vertikal tengah */
        }

        .customer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .customer-item {
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 14px;
            background: #fff;
            word-break: break-word;
        }

        @media (max-width: 768px) {
            .customer-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="container-fluid">
        <div class="d-flex justify-content-start mb-3"></div>
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">Create Ticket</h4>

                {{-- Info Ticket --}}
                <div class="d-flex justify-content-start mb-3">

                    <div class="me-4">
                        <strong>Ticket Unfinished :</strong> {{ $unfinished_ticket }} Tiket
                        <button class="btn btn-warning text-white btn-sm ms-2 btn-view-ticket" data-type="unfinished">
                            Lihat Detail
                        </button>
                    </div>

                    <div>
                        <strong>Ticket Bookmark Unfinished :</strong> {{ $unfinished_bookmark_ticket }} Tiket
                        <button class="btn btn-warning text-white btn-sm ms-2 btn-view-ticket" data-type="bookmarkUnfinished">
                            Lihat Detail
                        </button>
                    </div>

                </div>

                <hr>

                {{-- Form Create Ticket --}}
                <form action="{{ route('ticket.store') }}" method="POST">
                    @csrf

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
                            <select id="pilih_subject" name="id_subject" class="form-select select2-subject">
                                <option value="">Pilih Template Subject</option>
                                @foreach ($list_subject as $subject)
                                    <option value="{{ $subject->id_subject }}" data-isi="{{ $subject->isi_subject }}">
                                        {{ $subject->isi_subject }}
                                    </option>
                                @endforeach
                            </select>

                            <textarea class="form-control mt-2" rows="4" name="subject" id="subject"
                                placeholder="Tulis subject jika tidak pilih template..." required></textarea>
                        </div>
                    </div>


                    {{-- Jenis --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Jenis</label>
                        <div class="col-sm-10">
                            <select id="jenis" name="jenis" class="form-select" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value='1'>Multi Case</option>
                                <option value='0'>Single Case</option>
                            </select>
                        </div>
                    </div>





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





                    {{-- Kategori --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-10">
                            <select name="id_kategori" id="id_kategori" class="form-select select2" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($list_kategori as $kategori)
                                    <option value="{{ $kategori->id_kategori }}">
                                        {{ $kategori->nama_kategori }}
                                    </option>
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
                            <input type="date" class="form-control" name="tanggal" value="">
                        </div>
                        <div class="col-sm-1"></div>
                        <label class="col-sm-1 col-form-label">Jam</label>
                        <div class="col-sm-4">
                            <input type="time" class="form-control" name="jam" value="">
                        </div>
                    </div>

                    {{-- Tanggal Selesai & Jam --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Tanggal Selesai</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-sm-1"></div>
                        <label class="col-sm-1 col-form-label">Jam</label>
                        <div class="col-sm-4">
                            <input type="time" class="form-control">
                        </div>
                    </div>

                    <!-- LOKASI -->
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
                            <div class="col-md-2 ">
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
                            <div class="col-md-2 "></div>
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
                                <select id="pilih_deskripsi" name="id_deskripsi" class="form-select select2-deskripsi">
                                    <option value="">Pilih Template Deskripsi</option>
                                    @foreach ($list_deskripsi as $deskripsi)
                                        <option value="{{ $deskripsi->id_deskripsi }}" data-label="{{ $deskripsi->deskripsi }}">
                                            {{ $deskripsi->label_deskripsi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- id untuk simpan foto sementara -->
                            <input type="hidden" id="draft_id" name="draft_id" value="">
                            <div class="col-md-9">

                                <textarea name="deskripsi" id="deskripsi_text" class="form-control mt-2" rows="4"
                                    placeholder="Tulis deskripsi manual" required></textarea>
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
                                    <option value="{{ $spv->id_pengguna }}">{{ $spv->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Bookmark --}}
                    <div class="mb-3 row">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" value="1" name="bookmark" id="bookmark">
                                <label class="form-check-label" for="bookmark">Bookmark</label>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="mb-3 row">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('ticket.dashboard') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>

                </form>


                <!-- Modal Quick Ticket -->
                <div class="modal fade" id="ticketQuickModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content shadow-lg border-0">

                            <!-- Header -->
                            <div class="modal-header" style="background-color:#8B1E3F;color:white;">
                                <h5 class="modal-title fw-semibold" id="ticketQuickModalLabel"></h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Body -->
                            <div class="modal-body">
                                <div id="viewTicket">
                                    <!-- Control -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="d-inline-flex align-items-center">
                                                Show
                                                <select id="quickPerPage" class="form-select form-select-sm mx-2">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                                entries
                                            </label>
                                        </div>

                                        <div class="col-md-6 text-end">
                                            <label class="d-inline-flex align-items-center">
                                                Search:
                                                <input id="quickSearch" type="search"
                                                    class="form-control form-control-sm ms-2">
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Table -->
                                    <div class="table-responsive" style="max-height:400px;overflow:auto;">
                                        <table class="table table-bordered table-striped align-middle text-center">
                                            <thead class="table-light sticky-top">
                                                <tr>
                                                    <th class="th-merah">No</th>
                                                    <th class="th-merah">Subject</th>
                                                    <th class="th-merah">Customer</th>
                                                    <th class="th-merah">Create</th>
                                                    <th class="th-merah">Update
                                                        <hr /> Aging
                                                    </th>
                                                    <th class="th-merah">Updated By</th>
                                                    <th class="th-merah">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="quickTbody"></tbody>
                                        </table>
                                    </div>

                                    <!-- Footer -->
                                    <div class="row align-items-center mt-3">
                                        <div class="col-md-6" id="quickInfo">
                                            <small class="text-muted"></small>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="pagination pagination-sm justify-content-end mb-0"
                                                id="quickPagination">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div id="viewCustomer" class="d-none">

                                    <button class="btn btn-sm btn-outline-secondary mb-3" id="btnBackToTicket">
                                        Kembali ke Ticket
                                    </button>

                                    <h6 class="fw-semibold mb-2">Daftar Customer</h6>

                                    <div id="customerList" class="customer-grid"></div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
@endsection

        @section('script')

            {{-- ================== CSS & LIBRARY ================== --}}
            <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
            <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
            <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


        <script>
    function showTicketView() {
        document.getElementById('viewTicket').classList.remove('d-none');
        document.getElementById('viewCustomer').classList.add('d-none');
    }

    function showCustomerView(customersRaw) {
        const list = document.getElementById('customerList');
        list.innerHTML = '';

        customersRaw.split(',').forEach((cust, i) => {
            const div = document.createElement('div');
            div.className = 'customer-item';
            div.textContent = `${i + 1}. ${cust.trim()}`;
            list.appendChild(div);
        });

        document.getElementById('viewTicket').classList.add('d-none');
        document.getElementById('viewCustomer').classList.remove('d-none');
    }

    document.addEventListener('click', function (e) {

        // === BUKA VIEW CUSTOMER ===
        if (e.target.classList.contains('view-customer')) {
            e.preventDefault();

            const raw = decodeURIComponent(
                e.target.getAttribute('data-customers')
            );

            showCustomerView(raw);
        }

        // === KEMBALI KE TICKET ===
        if (e.target.id === 'btnBackToTicket') {
            showTicketView();
        }
    });
</script>

<script>
    const modal = document.getElementById('ticketQuickModal');

    modal.addEventListener('hidden.bs.modal', function () {
        showTicketView();
    });
</script>





            {{-- =================================================== --}}
            <script>
                window.AppData = {
                    baseUrl: "{{ url('') }}"
                },
                    $(function () {


                        /* =====================================================
                           UNFINISHED TICKET
                        ===================================================== */

                        const QuickTicket = {
                            type: null,
                            page: 1,
                            perPage: 10,
                            search: '',
                            debounce: null,

                            open(type) {
                                this.type = type;
                                this.page = 1;

                                const titles = {
                                    unfinished: 'Ticket Belum Selesai',
                                    bookmarkUnfinished : 'Ticket Bookmark Belum Selesai'
                                };

                                $('#ticketQuickModalLabel').text(titles[type]);
                                $('#ticketQuickModal').modal('show');
                                this.load();
                            },

                            load() {
                                const tbody = $('#quickTbody');
                                tbody.html(`<tr><td colspan="7">Memuat data...</td></tr>`);

                                $.get("{{ route('ticket.list') }}", {
                                    tab: this.type,
                                    page: this.page,
                                    per_page: this.perPage,
                                    search: this.search
                                })
                                    .done(res => {
                                        this.renderRows(res.data);
                                        this.renderPagination(res);
                                        this.renderInfo(res);
                                    })
                                    .fail(() => {
                                        tbody.html(`<tr><td colspan="7" class="text-danger">Gagal memuat data</td></tr>`);
                                    });
                            },

                            renderRows(data) {
                                const tbody = $('#quickTbody');
                                if (!data.length) {
                                    tbody.html(`<tr><td colspan="7">Tidak ada data</td></tr>`);
                                    return;
                                }

                                let html = '';
                                data.forEach((t, i) => {
                                    html += `
                                                        <tr>
                                                            <td>${t.id_ticket}</td>
                                                            <td>${t.subject}</td>
                                                            <td>
                ${(() => {
                                            if (!t.customer_numbers) return '-';

                                            const customers = t.customer_numbers
                                                .split(',')
                                                .map(c => c.trim())
                                                .filter(Boolean);

                                            const preview = customers.slice(0, 3);
                                            const remaining = customers.length - 3;

                                            let html = preview.join('<br>');

                                            if (remaining > 0) {
                                                html += `
                                <br>
                                <a href="#"
                                   class="text-primary fw-semibold view-customer"
                                   data-customers="${encodeURIComponent(customers.join(','))}">
                                   +${remaining} lihat
                                </a>
                            `;
                                            }

                                            return html;
                                        })()
                                        }
                </td>

                                                            <td>${t.created_at_formatted}<hr class="my-1">${t.total_replies} tanggapan</td>
                                                            <td>
                                                                ${t.updated_at_formatted}<hr class="my-1"><img src="${t.aging_icon}" width="14">
                                                                <span class="${t.aging_color}">${t.aging_display}</span>
                                                            </td>
                                                            <td>${t.last_handler_name ?? '-'}</td>
                                                            <td><span class="badge bg-biru">${t.status.nama_status}</span></td>
                                                        </tr>`;
                                });

                                tbody.html(html);
                            },

                            renderPagination(res) {
                                const pag = $('#quickPagination');
                                pag.empty();

                                const current = res.current_page;
                                const last = res.last_page;
                                const delta = 1;


                                let html = '';

                                // Prev
                                html += `
                                        <li class="page-item ${current === 1 ? 'disabled' : ''}">
                                            <a class="page-link" href="#" data-page="${current - 1}">Prev</a>
                                        </li>
                                    `;

                                // Page 1
                                if (current > delta + 1) {
                                    html += `
                                            <li class="page-item">
                                                <a class="page-link" href="#" data-page="1">1</a>
                                            </li>
                                        `;
                                }

                                // Ellipsis kiri
                                if (current > delta + 2) {
                                    html += `<li class="page-item disabled"><span class="page-link">…</span></li>`;
                                }

                                // Range tengah
                                const start = Math.max(1, current - delta);
                                const end = Math.min(last, current + delta);

                                for (let i = start; i <= end; i++) {
                                    html += `
                                            <li class="page-item ${i === current ? 'active' : ''}">
                                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                                            </li>
                                        `;
                                }

                                // Ellipsis kanan
                                if (current < last - delta - 1) {
                                    html += `<li class="page-item disabled"><span class="page-link">…</span></li>`;
                                }

                                // Page terakhir
                                if (current < last - delta) {
                                    html += `
                                            <li class="page-item">
                                                <a class="page-link" href="#" data-page="${last}">${last}</a>
                                            </li>
                                        `;
                                }

                                // Next
                                html += `
                                        <li class="page-item ${current === last ? 'disabled' : ''}">
                                            <a class="page-link" href="#" data-page="${current + 1}">Next</a>
                                        </li>
                                    `;

                                pag.html(html);
                            },


                            renderInfo(res) {
                                const text = res.total === 0
                                    ? 'Menampilkan 0 data'
                                    : `Menampilkan ${res.from} sampai ${res.to} dari ${res.total} data`;

                                $('#quickInfo small').text(text);
                            }
                        };

                        // EVENTS
                        $('#quickSearch').on('keyup', function () {
                            clearTimeout(QuickTicket.debounce);
                            QuickTicket.debounce = setTimeout(() => {
                                QuickTicket.search = this.value;
                                QuickTicket.page = 1;
                                QuickTicket.load();
                            }, 400);
                        });

                        $('#quickPerPage').on('change', function () {
                            QuickTicket.perPage = this.value;
                            QuickTicket.page = 1;
                            QuickTicket.load();
                        });

                        $(document).on('click', '#quickPagination a', function (e) {
                            e.preventDefault();
                            QuickTicket.page = $(this).data('page');
                            QuickTicket.load();
                        });

                        $(document).on('click', '.btn-view-ticket', function () {
                            const type = $(this).data('type');

                            if (!type) {
                                console.error('Ticket type tidak ditemukan');
                                return;
                            }

                            openQuickTicketModal(type);
                        });


                        // expose ke global
                        window.openQuickTicketModal = type => QuickTicket.open(type);









                        /* =====================================================
                           TICKET REFERENSI
                        ===================================================== */

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


                        /* =====================================================
                           SUBJECT TEMPLATE
                        ===================================================== */
                        $('.select2-subject').select2({
                            placeholder: "Pilih Template Subject",
                            allowClear: true,
                            width: '100%'
                        });

                        $('#pilih_subject').on('change', function () {
                            let isi = $(this).find(':selected').data('isi') || '';
                            $('#subject').val(isi);
                        });


                        /* =====================================================
                           DESKRIPSI + SUMMERNOTE
                        ===================================================== */
                        $('.select2-deskripsi').select2({
                            placeholder: "Pilih Template Deskripsi",
                            allowClear: true,
                            width: '100%'
                        });

                        $('#deskripsi_text').summernote({
                            height: 150,
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

                        $('#pilih_deskripsi').on('change', function () {
                            let label = $(this).find(':selected').data('label') || '';
                            $('#deskripsi_text').summernote('code', label);
                        });


                        if (!$('#draft_id').val()) {
                            $('#draft_id').val(crypto.randomUUID());
                        }

                        function uploadImage(file) {
                            let data = new FormData();
                            data.append("image", file);
                            data.append("_token", "{{ csrf_token() }}");
                            data.append('type', 'ticket');
                            data.append('draft_id', $('#draft_id').val());

                            $.ajax({
                                url: AppData.baseUrl + "/upload/summernote",
                                method: "POST",
                                data: data,
                                processData: false,
                                contentType: false,
                                success: function (res) {
                                    $('#deskripsi_text').summernote('insertImage', res.url);
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


                        /* =====================================================
                           MAP / LOKASI
                        ===================================================== */
                        const pilihLokasi = document.getElementById('pilih_lokasi');
                        const lokasiGangguan = document.querySelector('.lokasi_gangguan');
                        const lokasiGangguan2 = document.querySelector('.lokasi_gangguan2');
                        let map, marker;

                        if (pilihLokasi) {
                            pilihLokasi.addEventListener('change', function () {
                                lokasiGangguan.hidden = true;
                                lokasiGangguan2.hidden = true;

                                if (this.value === 'alamat') {
                                    lokasiGangguan.hidden = false;
                                } else if (this.value === 'alamat_koordinat') {
                                    lokasiGangguan.hidden = false;
                                    lokasiGangguan2.hidden = false;
                                    setTimeout(initMap, 200);
                                }
                            });
                        }

                        function initMap() {
                            if (!map) {
                                map = L.map('maps-input').setView([-7.797068, 110.370529], 13);

                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '© OpenStreetMap contributors'
                                }).addTo(map);

                                console.log('Map initialized.');
                                map.on('click', function (e) {
                                    const lat = e.latlng.lat.toFixed(6);
                                    const lng = e.latlng.lng.toFixed(6);

                                    $('#latitude').val(lat);
                                    $('#longitude').val(lng);

                                    if (marker) {
                                        marker.setLatLng(e.latlng);
                                    } else {
                                        marker = L.marker(e.latlng).addTo(map);
                                    }
                                });
                            } else {
                                map.invalidateSize();
                            }
                        }


                        /* =====================================================
                           JENIS CASE (MULTI / SINGLE)
                        ===================================================== */
                        $('#jenis').select2({
                            placeholder: '-- Pilih Jenis --',
                            allowClear: true,
                            width: '100%'
                        });

                        $('#id_status').select2({
                            placeholder: '-- Pilih Status --',
                            allowClear: true,
                            width: '100%'
                        });

                        $('#id_kategori').select2({
                            placeholder: '-- Pilih Kategori --',
                            allowClear: true,
                            width: '100%'
                        });

                        $('#dispatcher').select2({
                            placeholder: '-- Pilih SPV --',
                            allowClear: true,
                            width: '100%'
                        });

                        function handleJenisChange() {
                            if ($('#jenis').val() === '1') {
                                loadMultiCaseForm();
                                reloadCustomerGamas();
                            } else {
                                $('#jenis').val('0');
                                loadSingleCaseForm();
                                reloadCustomerSingle();
                            }
                        }

                        $('#jenis').val('0').trigger('change');
                        handleJenisChange();

                        $('#jenis').on('change', handleJenisChange);

                        $('#id_status').val('ST-001').trigger('change');



                        /* =====================================================
                        FORM BUILDER
                        ===================================================== */

                        function loadMultiCaseForm() {
                            $('#aturan').html(`{!! trim(preg_replace('/\s+/', ' ', "
                                                                                                                                    <div id='customer'>
                                                                                                                                    <div class='list_cust'>
                                                                                                                                        <hr>

                                                                                                                                        <div class='row mb-2'>
                                                                                                                                            <div class='col-md-2 text-right'>
                                                                                                                                                <label>Nama Pelanggan</label>
                                                                                                                                            </div>
                                                                                                                                            <div class='col-md-5'>
                                                                                                                                                    <select id='custNumber'
                                                                                                                                                        name='custNumber[]'
                                                                                                                                                        class='form-select pelanggan-select pelanggan-gamas select2'
                                                                                                                                                        required>
                                                                                                                                                    <option value=''>-- Pilih Pelanggan --</option>
                                                                                                                                                </select>
                                                                                                                                            </div>
                                                                                                                                        </div>

                                                                                                                                        <div class='row mb-2'>
                                                                                                                                            <div class='col-md-2 text-right'>
                                                                                                                                                <label>Nomor Telepon</label>
                                                                                                                                            </div>

                                                                                                                                            <div class='col-md-5'>
                                                                                                                                                <input type='text'
                                                                                                                                                        class='form-control custPhone nomor-gamas'
                                                                                                                                                        name='custPhone[]' />
                                                                                                                                            </div>

                                                                                                                                            <div class='col-md-2 btn-wrapper d-flex gap-2'>

                                                                                                                                    <button type='button' class='btn btn-danger remove-list'>
                                                                                                                                    <i class='bi bi-dash-lg'></i> {{-- lebih besar & tebal --}}
                                                                                                                                    </button>

                                                                                                                                    <button type='button' class='btn btn-primary add-list'>
                                                                                                                                    <i class='bi bi-plus-lg'></i> {{-- lebih besar & tebal --}}
                                                                                                                                    </button>
                                                                                                                                    </div>
                                                                                                                                            <input type='hidden' name='spCodeId' value='gamas'>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            ")) !!}`);
                        }

                        function loadSingleCaseForm() {
                            $('#aturan').html(`{!! trim(preg_replace('/\s+/', ' ', "
                                                                                                                                    <div class='mb-3 row'>
                                                                                                                                        <label class='col-sm-2 col-form-label'>Pelanggan</label>
                                                                                                                                        <div class='col-sm-10'>
                                                                                                                                            <select name='custNumber'
                                                                                                                                                    id='custNumber'
                                                                                                                                                    class='form-select'
                                                                                                                                                    required>
                                                                                                                                                <option value=''>-- Pelanggan --</option>
                                                                                                                                            </select>
                                                                                                                                        </div>
                                                                                                                                    </div>

                                                                                                                                    {{-- Layanan --}}
                                                                                                                                    <div class='mb-3 row'>
                                                                                                                                        <label class='col-sm-2 col-form-label'>Layanan</label>
                                                                                                                                        <div class='col-sm-10'>
                                                                                                                                            <select name='spCodeId'
                                                                                                                                                    id='spCodeId'
                                                                                                                                                    class='form-select'>
                                                                                                                                                <option value=''>-- Layanan --</option>
                                                                                                                                            </select>
                                                                                                                                        </div>
                                                                                                                                    </div>

                                                                                                                                    {{-- Nomor WA --}}
                                                                                                                                    <div class='mb-3 row'>
                                                                                                                                        <label class='col-sm-2 col-form-label'>Nomor Telepon</label>
                                                                                                                                        <div class='col-sm-10'>
                                                                                                                                            <input type='text'
                                                                                                                                                    name='custPhone'
                                                                                                                                                    id='custPhone'
                                                                                                                                                    class='form-control'>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                ")) !!}`);
                        }

                        /* =====================================================
                           CUSTOMER MULTI
                        ===================================================== */
                        function reloadCustomerGamas() {
                            $('.pelanggan-gamas').select2({
                                placeholder: '-- Pelanggan --',
                                width: '100%',
                                ajax: {
                                    delay: 300,
                                    url: "{{ route('ticket.customers') }}",
                                    data: params => ({
                                        q: params.term || '',
                                        page: params.page || 1
                                    }),
                                    processResults: (data, params) => {

                                        let keyword = params.term ? params.term.toLowerCase() : '';


                                        let filtered = data.data
                                            .filter(item =>
                                                !keyword ||
                                                item.custName.toLowerCase().includes(keyword) ||
                                                item.custNumber.toLowerCase().includes(keyword)
                                            )
                                            .slice(0, 20);

                                        //console.log(filtered);

                                        return {
                                            results: filtered.map(item => ({
                                                id: item.custNumber,
                                                text: item.custNumber + ' - ' + item.custName,
                                                custPhone: item.custPhone,
                                            })),
                                        }
                                        //pagination: { more: data.current_page < data.last_page }
                                    }
                                }
                            });

                            $(document).on('select2:select', '.pelanggan-gamas', function (e) {
                                let parent = $(this).closest('.list_cust');
                                parent.find('.nomor-gamas').val(e.params.data.custPhone);
                                pilihLokasi.value = 'alamat';
                                pilihLokasi.dispatchEvent(new Event('change'));
                            });

                        }

                        /* =====================================================
                           CUSTOMER SINGLE
                        ===================================================== */
                        function reloadCustomerSingle() {
                            $('#spCodeId').select2({
                                placeholder: '-- Pilih Layanan --',
                                allowClear: true, width: '100%'
                            });

                            $('#custNumber').select2({
                                placeholder: '-- Pelanggan --',
                                width: '100%',
                                ajax: {
                                    delay: 300,
                                    url: "{{ route('ticket.customers') }}",
                                    data: params => ({
                                        q: params.term || '',
                                        page: params.page || 1
                                    }),
                                    processResults: (data, params) => {

                                        let keyword = params.term ? params.term.toLowerCase() : '';


                                        let filtered = data.data
                                            .filter(item =>
                                                !keyword ||
                                                item.custName.toLowerCase().includes(keyword) ||
                                                item.custNumber.toLowerCase().includes(keyword)
                                            )
                                            .slice(0, 20);

                                        console.log(filtered);

                                        return {
                                            results: filtered.map(item => ({
                                                id: item.custNumber,
                                                text: item.custNumber + ' - ' + item.custName,
                                                custPhone: item.custPhone,
                                                spCodeId: item.spCodeId,
                                                spCode: item.spCode,
                                                address: item.custAddress,
                                                latitude: item.custLatitude,
                                                longitude: item.custLongitude
                                            })),
                                            //pagination: { more: data.current_page < data.last_page }
                                        }
                                    }
                                }
                            });

                            $('#custNumber').on('select2:select', function (e) {
                                let d = e.params.data;
                                $('#custPhone').val(d.custPhone);
                                $('#spCodeId').empty();

                                if (d.spCodeId) {
                                    $('#spCodeId').append(new Option(d.spCode, d.spCodeId, true, true)).trigger('change');
                                }
                                if (d.latitude && d.longitude) {
                                    pilihLokasi.value = 'alamat_koordinat';
                                    pilihLokasi.dispatchEvent(new Event('change'));
                                    $('#alamat').val(d.address);
                                    $('#latitude').val(d.latitude);
                                    $('#longitude').val(d.longitude);
                                } else {
                                    pilihLokasi.value = 'alamat';
                                    pilihLokasi.dispatchEvent(new Event('change'));
                                    $('#alamat').val(d.address);
                                    $('#latitude').val('');
                                    $('#longitude').val('');
                                }
                            });
                        }


                        /* =====================================================
                           ADD / REMOVE LIST
                        ===================================================== */
                        function updateAddRemoveButtons() {
                            const rows = $('#customer .list_cust');

                            rows.find('.add-list').remove();

                            if (rows.length === 0) return;

                            const lastRow = rows.last();

                            if (lastRow.find('.add-list').length === 0) {
                                lastRow.find('.btn-wrapper').append(`
                                                                        <button type="button" class="btn btn-primary add-list">
                                                                            <i class="bi bi-plus-lg"></i>
                                                                        </button>
                                                                    `);
                            }
                        }


                        $(document).on('click', '.add-list', function () {
                            $('#customer').append(`{!! trim(preg_replace('/\s+/', ' ', "
                                                                                                                                <div class='list_cust'> <hr>

                                                                                                                                    <div class='row mb-2'>
                                                                                                                                    <div class='col-md-2 text-right'>
                                                                                                                                    <label>Nama Pelanggan</label>
                                                                                                                                    </div>
                                                                                                                                    <div class='col-md-5'>
                                                                                                                                    <select 
                                                                                                                                    name='custNumber[]'
                                                                                                                                    class='form-select pelanggan-select pelanggan-gamas select2'
                                                                                                                                    required>
                                                                                                                                    <option value=''>-- Pilih Pelanggan --</option>
                                                                                                                                    </select>
                                                                                                                                    </div>
                                                                                                                                    </div>

                                                                                                                                    <div class='row mb-2'>
                                                                                                                                    <div class='col-md-2 text-right'>
                                                                                                                                    <label>Nomor Telepon</label>
                                                                                                                                    </div>

                                                                                                                                    <div class='col-md-5'>
                                                                                                                                    <input type='text'
                                                                                                                                    class='form-control custPhone nomor-gamas'
                                                                                                                                    name='custPhone[]' />
                                                                                                                                    </div>


                                                                                                                                    <div class='col-md-2 btn-wrapper d-flex gap-2'>
                                                                                                                                    <button type='button' class='btn btn-danger remove-list'>
                                                                                                                                    <i class='bi bi-dash-lg'></i> {{-- lebih besar & tebal --}}
                                                                                                                                    </button>
                                                                                                                                    <button type='button' class='btn btn-primary add-list'>
                                                                                                                                    <i class='bi bi-plus-lg'></i> {{-- lebih besar & tebal --}}
                                                                                                                                    </button>
                                                                                                                                    </div>




                                                                                                                                    <input type='hidden' name='spCodeId' value='gamas'>
                                                                                                                                    </div> </div>")) !!}`);
                            reloadCustomerGamas();
                            updateAddRemoveButtons();
                        });

                        $(document).on('click', '.remove-list', function (e) {
                            e.preventDefault();

                            const rows = $('#customer .list_cust');

                            if (rows.length === 1) {
                                alert('Minimal harus ada 1 baris!');
                                return;
                            }

                            $(this).closest('.list_cust').remove();

                            updateAddRemoveButtons();
                        });


                    });
            </script>

        @endsection