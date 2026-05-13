@extends('layout.layout_sidebar')

@section('title', 'Report')

@section('content')

    <style>
        .stat-card {
            border-radius: 18px;
            transition: 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
        }

        .icon-box {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            transition: 0.3s ease;
            color: white !important;
        }

        .bg-danger {
            background: linear-gradient(135deg, #ff6b6b, #c91818) !important;
        }

        .bg-success {
            background: linear-gradient(135deg, #3ac569, #048c37) !important;
        }

        .bg-primary {
            background: linear-gradient(135deg, #4f93ff, #0056d6) !important;
        }

        .icon-box i {
            animation: pulse 2s infinite ease-in-out;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.15);
            }

            100% {
                transform: scale(1);
            }
        }

        .stat-card:hover .icon-box i {
            animation: wiggle 0.4s ease-in-out;
        }

        @keyframes wiggle {
            0% {
                transform: rotate(0deg);
            }

            30% {
                transform: rotate(10deg);
            }

            60% {
                transform: rotate(-10deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        .section-title {
            border-left: 4px solid #F0B84A;
            padding-left: 10px;
            font-weight: 700;
            margin-bottom: 12px;
        }
    </style>

    <div class="container-fluid mt-3">

        <h4 class="mb-3">Report Ticketing</h4>

        {{-- FILTER --}}
        <div class="card shadow-sm mb-4" style="border-radius: 14px; border-left: 4px solid #F0B84A;">
            <div class="card-body">
                <form class="row g-3 align-items-end" onsubmit="return false;">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tanggal Mulai</label>
                        <input type="date" id="startDate" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tanggal Akhir</label>
                        <input type="date" id="endDate" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <button type="button" id="btnCari" class="btn btn-warning text-white fw-semibold"
                            style="padding:6px 8px; border-radius:8px;">
                            Cari
                        </button>
                        <button type="button" id="btnReset" class="btn btn-secondary">
                            Reset
                        </button>
                    </div>


                </form>
            </div>
        </div>

        <h5 id="judulReport" class="fw-bold mb-3">Statistik Ticket Bulan
            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
        </h5>

        <div id="report-content">
            {{-- Render default card saat load pertama --}}
            @foreach ($report as $item)
                <div class="mb-4">
                    <h6 class="section-title">{{ $item['kategori'] }}</h6>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="stat-card card shadow-sm border-0 h-100">
                                <div class="card-body d-flex align-items-center">
                                    <div class="icon-box bg-danger me-3 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-pencil-square"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">{{ $item['total_ticket'] }}</h5>
                                        <small class="text-muted">Total Ticket</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="stat-card card shadow-sm border-0 h-100">
                                <div class="card-body d-flex align-items-center">
                                    <div class="icon-box bg-success me-3 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-check2-square"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">{{ $item['total_aging'] }}</h5>
                                        <small class="text-muted">Total Aging Ticket</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="stat-card card shadow-sm border-0 h-100">
                                <div class="card-body d-flex align-items-center">
                                    <div class="icon-box bg-primary me-3 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">{{ $item['avg_aging'] }}</h5>
                                        <small class="text-muted">Average Aging Ticket</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection

@section('script')
    <script>
        function renderCard(color, icon, value, label) {
            return `
            <div class="stat-card card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box bg-${color} me-3 d-flex align-items-center justify-content-center">
                        <i class="bi ${icon}"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">${value}</h5>
                        <small class="text-muted">${label}</small>
                    </div>
                </div>
            </div>`;
        }

        $(document).ready(function () {

            $('#btnCari').on('click', function () {

                let start = $('#startDate').val();
                let end = $('#endDate').val();

                if (!start || !end) {
                    alert('Tanggal harus diisi!');
                    return;
                }

                $.ajax({
                    url: "{{ route('report.filter') }}",
                    method: "GET",
                    data: {
                        startDate: start,
                        endDate: end
                    },
                    success: function (res) {

                        // UBAH JUDUL
                        const formatTanggal = (tgl) => {
                            const d = new Date(tgl);
                            return d.toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric'
                            });
                        };

                        $('#judulReport').text(
                            `Statistik Ticket Periode ${formatTanggal(start)} – ${formatTanggal(end)}`
                        );

                        $('#report-content').html('');

                        if (!res.data || res.data.length === 0) {
                            $('#report-content').html(
                                '<div class="text-muted">Tidak ada data untuk rentang tanggal ini.</div>'
                            );
                            return;
                        }

                        res.data.forEach(function (item) {
                            $('#report-content').append(`
                                <div class="mb-4">
                                    <h6 class="section-title">${item.kategori}</h6>
                                    <div class="row g-4">
                                        <div class="col-md-4">
                                            ${renderCard('danger', 'bi-pencil-square', item.total_ticket, 'Total Ticket')}
                                        </div>
                                        <div class="col-md-4">
                                            ${renderCard('success', 'bi-check2-square', item.total_aging, 'Total Aging Ticket')}
                                        </div>
                                        <div class="col-md-4">
                                            ${renderCard('primary', 'bi-clock-history', item.avg_aging, 'Average Aging Ticket')}
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert('Terjadi error saat memuat data');
                    }
                });

            });

            $('#btnReset').on('click', function () {
                $('#startDate').val('');
                $('#endDate').val('');

                $('#judulReport').text(
                    'Statistik Ticket Bulan {{ now()->translatedFormat("F Y") }}'
                );

                location.reload(); // atau panggil ulang data default
            });

        });
    </script>
@endsection