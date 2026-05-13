@extends('layout.layout_sidebar')

@section('title', 'History Ticket')

@section('content')
    <div class="container-fluid mt-3">
        <h4 class="mb-3">History Ticket</h4>

        {{-- Card utama --}}
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #fff;">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 fw-semibold me-3" style="color:#8B1E3F;">
                        Ticket #{{ $ticket->id_ticket }}
                    </h5>

                    <a href="{{ route('ticket.update', $ticket->hash_id) }}"
                        class="btn btn-success fw-semibold px-3">Update Ticket</a>
                </div>
            </div>

            <style>
                .penanganan-cell, .deskripsi-gangguan {
            max-width: 100%;
            overflow-y: auto;
            overflow-x: auto;
            text-align: left;
        }

        .penanganan-cell img {
            max-width: 100%;
            height: auto;
        }
            </style>

            <form action="{{ route('ticket.detail', ['id_ticket' => $ticket->id_ticket]) }}" method="GET">
                {{-- Detail Ticket --}}
                <div class="card-body">
                    <h6 class="fw-bold mb-3" style="color:#333;">Detail Ticket</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered text-center align-middle">
                            <thead style="background-color:#8B1E3F; color:white;">
                                <tr>
                                    <th class="th-merah">Subject</th>
                                    <th class="th-merah">Layanan</th>
                                    <th class="th-merah">Kategori</th>
                                    <th class="th-merah">Jenis Ticket</th>
                                    <th class="th-merah">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $ticket->subject }}</td>
                                    <td>
                                        @if ($ticket->jenis == 0)
                                            {{ $ticket->customer_list->first()['spCode'] ?? '-' }}
                                        @else
                                            gamas
                                        @endif
                                    </td>

                                    <td>{{ $ticket->kategori->nama_kategori ?? '-' }}</td>
                                    <td>{{ $ticket->jenis === null ? '-' : ($ticket->jenis == 1 ? 'Multi Case' : 'Single Case') }}
                                    </td>
                                    <td><span class="badge bg-biru">{{ $ticket->status->nama_status }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    {{-- Detail Pelanggan --}}
                    <h6 class="fw-bold mb-3">Detail Pelanggan</h6>

                    <div class="mb-3">

                        {{-- MULTI CASE --}}
                        @if ($ticket->jenis == 1)

                            <div class="row mb-2">
                                <div class="col-md-3 fw-semibold">Pelanggan</div>
                                <div class="col-md-9">
                                    :
                                    {{ $ticket->customer_list->pluck('custName')->filter()->join(', ') }}
                                </div>
                            </div>

                            {{-- SINGLE CASE --}}
                        @else

                            @php
                                $cust = $ticket->customer_list->first();
                            @endphp

                            <div class="row mb-2">
                                <div class="col-md-3 fw-semibold">Pelanggan</div>
                                <div class="col-md-9">: {{ $cust['custName'] ?? '-' }}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-3 fw-semibold">Nomor</div>
                                <div class="col-md-9">: {{ $cust['custPhone'] ?? '-' }}</div>
                            </div>

                        @endif

                    </div>

                    <!-- <div class="th-merah" style="height:2px;"></div> -->

                    <div style="height:2px; background-color:#8B1E3F; margin:30px 0 20px;"></div>




                    {{-- Detail Gangguan --}}
                    <h6 class="fw-bold mb-3">Detail Gangguan</h6>

                    <div class="mb-3">

                        <div class="row mb-2">
                            <div class="col-md-3 fw-semibold">Waktu Gangguan</div>
                            <div class="col-md-9">: {{ $ticket->waktu_gangguan }}</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-3 fw-semibold">Gangguan Solved</div>
                            <div class="col-md-9">: {{ $ticket->gangguan_solved }}</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-3 fw-semibold">Lokasi Gangguan</div>
                            <div class="col-md-9">: {{ $ticket->alamat ?? '-' }}
                                @if ($ticket->latitude && $ticket->longitude)
                                    <div class="mb-4">
                                        <div id="maps-view" style="height:300px; width:100%;"></div>
                                @endif

                                </div>

                            </div>

                            <div class="row mb-2 align-items-start">
                                <div class="col-md-3 fw-semibold">Deskripsi Gangguan</div>
                                <div class="col-md-9 d-flex">
                                    <span class="me-1">:</span>
                                    <div class="deskripsi-gangguan">
                                        {!! $ticket->deskripsi !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- <div class="th-merah" style="height:2px;"></div> -->
                        <div style="height:2px; background-color:#8B1E3F; margin:30px 0 20px;"></div>




                        {{-- History Penanganan --}}
                        <h6 class="fw-bold mb-3">History Penanganan</h6>
                        @foreach ($list_penanganan as $key => $penanganan)
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-3 fw-semibold">{{ $penanganan->tanggal_proses }}</div>
                                <div class="col-md-7">
                                    <div class="penanganan-cell">
                                                {!! $penanganan->penanganan !!}
                                            </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn- btn-warning text-white mb-2" data-bs-toggle="modal"
                                        data-bs-target="#modalDetailPenanganan"
                                        data-tanggal="{{ $penanganan->created_at_formatted }}"
                                        data-penanganan="{!! htmlspecialchars($penanganan->penanganan, ENT_QUOTES) !!}"
                                        data-status="{{ $penanganan->nama_status }}" data-user="{{ $penanganan->nama }}"
                                        data-dokumentasi="{{ $penanganan->dokumentasi }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>


                            </div>
                        @endforeach
                        <div class="row mb-2">
                            <div class="col-md-3 fw-semibold">Aging Penanganan</div>
                            <div class="col-md-9">
                                :
                                <span class="d-inline-flex align-items-center">
                                    <img src="{{ url($ticket->aging_icon) }}" alt="Icon Aging"
                                        style="width:16px; height:16px; position: relative; top: 2px;">

                                    <span class="{{ $ticket->aging_color }} ms-1">
                                        {{ $ticket->aging_display }} 
                                    </span>
                                </span>
                            </div>

                            
                        <!-- Modal Detail Penanganan -->
                        @include('Ticket.History_Penanganan.detail_penanganan')

@endsection

@section('script')

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- Leaflet Fullscreen --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet.fullscreen@1.6.0/Control.FullScreen.css">
    <script src="https://unpkg.com/leaflet.fullscreen@1.6.0/Control.FullScreen.js"></script>



    <script>

        const base_url = "{{ url('') }}";
        const asset_url = "{{ asset('') }}";
        window.AppData = {
            latitude: {{ $ticket->latitude ?? 'null'}},
            longitude: {{ $ticket->longitude ?? 'null'}}
                };

        const detailModal = document.getElementById('modalDetailPenanganan');
        detailModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const tanggal = button.getAttribute('data-tanggal');
            const penanganan = button.getAttribute('data-penanganan');
            const status = button.getAttribute('data-status');
            const user = button.getAttribute('data-user');
            const dokumentasi = button.getAttribute('data-dokumentasi');

            document.getElementById('detailTanggal').textContent = tanggal;
            document.getElementById('detailPenanganan').innerHTML = penanganan;
            document.getElementById('detailStatus').textContent = status;
            document.getElementById('detailUser').textContent = user;

            const dokElement = document.getElementById('detailDokumentasi');
            dokElement.innerHTML = '';

            if (dokumentasi) {
                const fileUrl = `${asset_url}/storage/${dokumentasi}`;
                const fileExt = dokumentasi.split('.').pop().toLowerCase();

                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExt)) {
                    dokElement.innerHTML = `
                        <a href="${fileUrl}" target="_blank">
                            <img src="${fileUrl}" alt="Dokumentasi" 
                                    class="img-fluid rounded shadow-sm" style="max-width:200px;">
                        </a>
                    `;

                } else {
                    dokElement.innerHTML = `
                        <a href="${fileUrl}" target="_blank" class="btn btn-sm btn-secondary">
                            Download File Dokumentasi
                        </a>
                    `;
                }
            } else {
                dokElement.innerHTML = `<em>Tidak ada dokumentasi</em>`;
            }
        });
    </script>
    <script>
        const MapViewer = {
            map: null,

            init(lat, lng) {
                if (!lat || !lng) return;

                this.map = L.map('maps-view', {
                    dragging: true,
                    scrollWheelZoom: false,
                    doubleClickZoom: false,
                    boxZoom: true,
                    keyboard: true,
                    zoomControl: false,
                    fullscreenControl: true
                }).setView([lat, lng], 15);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png')
                    .addTo(this.map);

                L.marker([lat, lng]).addTo(this.map);
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            MapViewer.init(AppData.latitude, AppData.longitude);
        });
    </script>

@endsection