@extends('layout.layout_sidebar')
@section('title', 'Dashboard Ticket')
@section('content')
    <div class="container mt-3">

        <h4 class="mb-3">Dashboard Ticket</h4>

        @push('styles')
            <style>
                /* Default tab warna normal */
                .nav-tabs .nav-link {
                    color: #dc3545;
                    /* abu default */
                }

                /* Saat tab aktif diklik */
                .nav-tabs .nav-item .nav-link.active {
                    background-color: #dc3545;
                    /* merah bootstrap */
                    color: #0d6efd !important;
                }

                /* Hover biar ada efek */
                .nav-tabs .nav-link:hover {
                    color: #dc3545;
                }
            </style>
        @endpush

        <style>
           


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


            .customer-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
            }

            /* Item */
            .customer-grid .customer-item {
                padding: 8px 10px;
                border: 1px solid #e5e7eb;
                border-radius: 6px;
                font-size: 14px;
                background-color: #fff;
                word-break: break-word;
            }

            /* Mobile fallback */
            @media (max-width: 768px) {
                .customer-grid {
                    grid-template-columns: repeat(1, 1fr);
                }
            }
            
    </style>

        {{-- Filter --}}
        {{-- filter card — pasang ini di tempat filter lama --}}
        <div class="card shadow-sm p-4 mb-4" style="border-radius:12px;">
            <div class="row align-items-end g-3">
                <!-- Tanggal Mulai -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold mb-1">Tanggal Mulai</label>
                    <input type="date" id="tgl_mulai" class="form-control form-control-sm" placeholder="tanggal mulai"
                        value="">
                </div>

                <!-- Tanggal Akhir -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold mb-1">Tanggal Akhir</label>
                    <input type="date" id="tgl_akhir" class="form-control form-control-sm" value="">
                </div>

                <!-- Jenis Ticket -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold mb-1">Jenis Ticket</label>
                    <select id="jenis" class="form-select select2 select2-sm">
                        <option value="">Semua Jenis</option>
                        <option value="0">Single Case</option>
                        <option value="1">Multi Case</option>

                    </select>
                </div>

                <!-- Kategori Ticket -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold mb-1">Kategori Ticket</label>
                    <select id="kategori" class="form-select select2 select2-sm">
                        <option value="">Semua Kategori</option>
                        @foreach ($list_kategori as $kategori)
                            <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Layanan -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold mb-1">Layanan</label>
                    <select id="layanan" name="spCodeId" class="form-select select2 select2-sm">
                        <option value="">Semua Layanan</option>
                        @foreach ($list_layanan as $layanan)
                            <option value="{{ $layanan['spCodeId'] }}">{{ $layanan['spCode'] }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-4 mt-2">
                    <label class="form-label fw-semibold mb-1">Status Ticket</label>
                    <select id="status" class="form-select select2 select2-sm">
                        <option value="">Semua Status Ticket</option>
                        @foreach ($list_status as $status)
                            <option value="{{ $status->id_status }}">{{ $status->nama_status }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- <i class="bi bi-search me-1"></i> -->
                <div class="col-md-2 mt-2 d-flex align-items-end">
                    <button type="button" id="btnCari" class="btn btn-warning text-white fw-semibold"
                        style="padding:6px 8px; border-radius:8px;">
                        Cari
                    </button>

                    <!-- <button type="button" id="btnCari" class="btn fw-semibold"
                                                                                                                                        style="background:#F0B84A; color:#fff; padding:6px 15px; border-radius:8px;">
                                                                                                                                        Cari
                                                                                                                                    </button> -->
                </div>
            </div>


            <hr class="my-3">

            {{-- Tombol menuju ke form Create Ticket--}}
            <div class="d-flex justify-content-start">
                <a href="{{ route('ticket.create') }}" class="btn btn-primary fw-semibold px-4 py-2 mb-3"
                    style="border-radius:8px;">Create Ticket</a>
            </div>


            {{-- tambahan CSS kecil (boleh taruh di atas blade atau di file css global) --}}
            <style>
                /* haluskan input/select ukuran kecil agar sama tampilan gambar */
                .form-control-sm,
                .select2-sm {
                    height: calc(1.7rem + 0.6rem);
                    padding: 0.4rem 0.75rem;
                    font-size: 0.95rem;
                }

                /* kecilkan label spacing */
                .card .form-label {
                    font-size: 0.95rem;
                }

                /* shadow & rounding konsisten */
                .card.shadow-sm {
                    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.03);
                }

                .table th {
                    text-align: center;
                    /* horizontal tengah */
                    vertical-align: middle;
                    /* vertikal tengah */
                }
            </style>


            <style>
                /* Tab normal (tidak aktif) */
                .nav-tabs .nav-link {
                    color: #000 !important;
                    /* hitam */
                    border: none !important;
                    border-radius: 8px 8px 0 0 !important;
                    background: transparent !important;
                    padding: 8px 18px;
                }

                /* Tab aktif */
                .nav-tabs .nav-link.active {
                    background-color: #b13253 !important;
                    /* merah seperti contoh gambar */
                    color: #fff !important;
                    /* putih */
                    border: none !important;
                    border-radius: 8px 8px 0 0 !important;
                    font-weight: 600;
                }

                /* Hilangkan garis border default bootstrap */
                .nav-tabs {
                    border-bottom: 1px solid #dee2e6 !important;
                }
            </style>

            <style>
                .bg-biru {
                    background-color: #54A5FA !important;
                    /* biru muda*/
                    color: #fff !important;
                }
            </style>


            {{-- Tab Menu --}}
            <ul class="nav nav-tabs mb-3 mt-4" id="ticketTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link fw-semibold active" data-bs-toggle="tab" data-tab="terkini">Ticket
                        Terkini</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-semibold" data-bs-toggle="tab" data-tab="bookmark">Bookmark
                        Ticket</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-semibold" data-bs-toggle="tab" data-tab="history">History
                        Ticket</button>
                </li>
            </ul>


            <div class="row align-items-center">
                <div class="col-md-6">
                    <label class="d-flex align-items-center gap-2 mb-0">
                        Show
                        <select id="perPage" class="form-select select2-sm" style="width:80px">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        entries
                    </label>
                </div>
                <div class="col-md-6 text-end">
                    <label class="d-flex justify-content-end align-items-center gap-2 mb-0">
                        Search
                        <input type="text" id="search" class="form-control form-control-sm" style="width:250px">
                    </label>
                </div>
            </div>

            {{-- Ticket Tab --}}
            <div class="table-wrapper" style="max-height:600px; overflow-y:auto;">
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-light" style="position: sticky; top: 0; z-index: 2;">
                        <tr>
                            <th class="th-merah">ID</th>
                            <th class="th-merah">Subject</th>
                            <th class="th-merah">Customer ID</th>
                            <th class="th-merah">Create</th>
                            <th class="th-merah">Update
                                <hr /> Aging Ticket
                            </th>
                            <th class="th-merah">Updated By</th>
                            <th class="th-merah">Status</th>
                            <th class="th-merah">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="ticket-body"></tbody>
                </table>
                <div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Daftar Customer</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <div id="customerList" class="customer-grid"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-center mt-3">

                <div class="col-md-6" id="table-info">
                    <small class="text-muted"></small>
                </div>


                <div class="col-md-6">
                    <ul class="pagination justify-content-end mb-0" id="ticket-pagination"></ul>
                </div>

            </div>

        </div>
@endsection

    @section('script')
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
            <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
                rel="stylesheet">

            <script>
                document.getElementById('customerModal')
                    .addEventListener('show.bs.modal', function (event) {

                        const btn = event.relatedTarget;
                        const raw = decodeURIComponent(btn.getAttribute('data-customers'));

                        const list = document.getElementById('customerList');
                        list.innerHTML = '';

                        raw.split(',').forEach((cust, i) => {
                            const div = document.createElement('div');
                            div.className = 'customer-item';
                            div.textContent = `${i + 1}. ${cust.trim()}`;
                            list.appendChild(div);
                        });
                    });

            </script>

            <script>
                // GLOBAL STATE
                // Digunakan sebagai single source of truth
                let state = {
                    tab: 'terkini',
                    page: 1,
                    perPage: 10,
                    search: '',
                    sort: {
                        by: 'created_at',
                        dir: 'desc'
                    },
                    filters: {
                        tgl_mulai: '',
                        tgl_akhir: '',
                        jenis: '',
                        kategori: '',
                        layanan: '',
                        status: ''
                    }
                };


                let debounceTimer = null;

                // ROUTE TEMPLATE
                // Placeholder :id akan diganti saat render
                const routeHistory = "{{ route('ticket.history', ':id') }}";
                const routeUpdate = "{{ route('ticket.update', ':id') }}";
                const routeDelete = "{{ route('ticket.destroy', ':id') }}";
                const routeBookmark = "{{ route('ticket.bookmark', ':id') }}";

                $(document).ready(function () {

                    // Load data pertama kali halaman dibuka
                    $('.select2').select2({
                        theme: 'bootstrap-5',
                        width: '100%'
                    });

                    loadTickets();

                    // EVENT HANDLER

                    // Pindah tab
                    $('button[data-tab]').on('click', function () {
                        state.tab = $(this).data('tab');
                        state.page = 1;
                        loadTickets();
                    });

                    // Tombol cari manual
                    $('#btnCari').on('click', function () {
                        state.filters = {
                            tgl_mulai: $('#tgl_mulai').val(),
                            tgl_akhir: $('#tgl_akhir').val(),
                            jenis: $('#jenis').val(),
                            kategori: $('#kategori').val(),
                            layanan: $('#layanan').val(),
                            status: $('#status').val()
                        };
                        state.page = 1;
                        loadTickets();
                    });


                    // Search realtime dengan debounce
                    $('#search').on('keyup', function () {
                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(() => {
                            state.search = $(this).val();
                            state.page = 1;
                            loadTickets();
                        }, 500);
                    });

                    // Perubahan jumlah data per halaman
                    $('#perPage').on('change', function () {
                        state.perPage = $(this).val();
                        state.page = 1;
                        loadTickets();
                    });
                });


                // AJAX LOAD DATA
                function loadTickets() {

                    const tbody = '#ticket-body';

                    // Placeholder loading
                    $(tbody).html(`
                                    <tr>
                                        <td colspan="8" class="text-center">Memuat data...</td>
                                    </tr>
                                `);

                    $.ajax({
                        url: "{{ route('ticket.list') }}",
                        type: "GET",
                        data: {
                            tab: state.tab,
                            page: state.page,
                            per_page: state.perPage,
                            search: state.search,
                            ...state.filters
                        },
                        success: function (res) {
                            renderRows(res.data, tbody);
                            renderPagination(res);
                            renderInfo(res);
                        },
                        error: function () {
                            $(tbody).html(`
                                            <tr>
                                                <td colspan="8" class="text-center">Tidak ada data ticket</td>
                                            </tr>
                                        `);
                        }
                    });
                }



                // RENDER TABLE ROWS
                function renderRows(data, tbody) {
                    let rows = '';

                    if (!data || data.length === 0) {
                        rows = `
                                <tr>
                                    <td colspan="8" class="text-center">
                                        Tidak ada data ditemukan.
                                    </td>
                                </tr>
                            `;
                        $(tbody).html(rows);
                        return;
                    }

                    $.each(data, function (index, ticket) {

                        const isClosed = ticket.status.nama_status?.toLowerCase() === 'closed';

                        rows += `
                        <tr>
                            <td>${ticket.id_ticket}</td>
                            <td>${ticket.subject}</td>
                            <td>
                                ${(() => {
                                            if (!ticket.customer_numbers) return '-';

                                            const customers = ticket.customer_numbers.split(',').map(c => c.trim());
                                            const preview = customers.slice(0, 3);
                                            const remaining = customers.length - 3;

                                            let html = preview.join('<br>');

                                            if (remaining > 0) {
                                                html += `
                                        <br>
                                        <a href="javascript:void(0)"
                                        class="text-primary fw-semibold"
                                        data-bs-toggle="modal"
                                        data-bs-target="#customerModal"
                                        data-customers="${encodeURIComponent(ticket.customer_numbers)}">
                                            +${remaining} lihat
                                        </a>
                                    `;
                                            }

                                            return html;
                                        })()
                                    }
                            </td>
                            <td>
                                ${ticket.created_at_formatted}
                                <hr class="my-1">
                                ${ticket.total_replies} Tanggapan
                            </td>
                            <td>
                                ${ticket.updated_at_formatted}
                                <hr class="my-1">
                                <img src="${ticket.aging_icon}" width="14">
                                <span class="${ticket.aging_color}">
                                    ${ticket.aging_display}
                                </span>
                            </td>
                            <td>${ticket.last_handler_name ?? '-'}</td>
                            <td>
                                <span class="badge bg-biru">
                                    ${ticket.status.nama_status ?? '-'}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">

                                    ${isClosed
                                    ? `<a href="${routeHistory.replace(':id', ticket.hash_id)}"
                                            class="btn btn-warning btn-sm text-white mb-2">
                                            <i class="bi bi-eye"></i>
                                        </a>`
                                    : `<a href="${routeUpdate.replace(':id', ticket.hash_id)}"
                                            class="btn btn-success btn-sm text-white mb-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>`
                                }

                                        <form action="${routeDelete.replace(':id', ticket.hash_id)}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-danger btn-sm text-white mb-2"
                                                    onclick="return confirm('Yakin ingin menghapus tiket ini?')">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>

                                        <form action="${routeBookmark.replace(':id', ticket.hash_id)}"
                                            method="POST">
                                            @csrf
                                            <button class="btn btn-primary btn-sm text-white mb-2"
                                                    type="submit">
                                                <i class="bi ${ticket.bookmark == 1
                                                    ? 'bi-bookmark-fill'
                                                    : 'bi-bookmark'}"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        `;
                    });

                    $(tbody).html(rows);
                }


                // PAGINATION
                function renderPagination(res) {
                    const paginationId = '#ticket-pagination';
                    let html = '';

                    const current = res.current_page;
                    const last = res.last_page;
                    const delta = 1; // jarak halaman kiri-kanan

                    // Prev
                    html += `
                                <li class="page-item ${current === 1 ? 'disabled' : ''}">
                                    <a class="page-link" href="#" onclick="changePage(${current - 1})">Prev</a>
                                </li>
                            `;

                    // Page 1
                    if (current > delta + 1) {
                        html += `
                                    <li class="page-item">
                                        <a class="page-link" href="#" onclick="changePage(1)">1</a>
                                    </li>
                                `;
                    }

                    // Ellipsis kiri
                    if (current > delta + 2) {
                        html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    }

                    // Page range tengah
                    const start = Math.max(1, current - delta);
                    const end = Math.min(last, current + delta);

                    for (let i = start; i <= end; i++) {
                        html += `
                                    <li class="page-item ${i === current ? 'active' : ''}">
                                        <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                                    </li>
                                `;
                    }

                    // Ellipsis kanan
                    if (current < last - delta - 1) {
                        html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
                    }

                    // Page terakhir
                    if (current < last - delta) {
                        html += `
                                    <li class="page-item">
                                        <a class="page-link" href="#" onclick="changePage(${last})">${last}</a>
                                    </li>
                                `;
                    }

                    // Next
                    html += `
                                <li class="page-item ${current === last ? 'disabled' : ''}">
                                    <a class="page-link" href="#" onclick="changePage(${current + 1})">Next</a>
                                </li>
                            `;

                    $(paginationId).html(html);
                }


                function changePage(page) {
                    if (page < 1) return;
                    state.page = page;
                    loadTickets();
                }

                function renderInfo(res) {
                    let info = '';

                    if (res.total === 0) {
                        info = 'Menampilkan 0 data';
                    } else {
                        info = `Menampilkan ${res.from} sampai ${res.to} dari ${res.total} data`;
                    }

                    $('#table-info small').text(info);
                }


            </script>
    @endsection