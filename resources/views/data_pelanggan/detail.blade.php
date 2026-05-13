@extends('layout.layout_sidebar')

@section('title', 'Detail Pelanggan')

@section('content')

<style>

.detail-card {
    width: 100%;
    max-width: 1050px; 
    margin: auto;
}

.detail-row {
    display: grid;
    grid-template-columns: 110px auto; 
    align-items: start;
    column-gap: 12px;

    padding: 6px 0;
    border-bottom: 1px dashed #e0e0e0;
}

.detail-label {
    font-weight: 600;
    color: #000;
    white-space: nowrap;
}

.detail-value {
    color: #000;
    word-break: break-word;
}

</style>

<div class="app-content-header">
    <div class="container-fluid">
        <h4 class="mb-0">Detail Pelanggan</h4>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        <div class="card detail-card">
            <div class="card-body">

                <div class="detail-row">
                    <div class="detail-label">CID</div>
                    <div class="detail-value">: {{ $datapelanggan->custNumber }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Nama</div>
                    <div class="detail-value">: {{ $datapelanggan->custName }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">: {{ $datapelanggan->custEmail ?? '-' }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">No WA</div>
                    <div class="detail-value">: {{ $datapelanggan->custPhone }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Provinsi</div>
                    <div class="detail-value">: {{ $datapelanggan->custProvince }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Kota / Kab</div>
                    <div class="detail-value">: {{ $datapelanggan->custDistrict }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Kecamatan</div>
                    <div class="detail-value">: {{ $datapelanggan->custSubDistrict }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Kelurahan</div>
                    <div class="detail-value">: {{ $datapelanggan->custVillage }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Alamat</div>
                    <div class="detail-value">: {{ $datapelanggan->custAddress }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">ID Layanan</div>
                    <div class="detail-value">: {{ $datapelanggan->spCodeId }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Kode Layanan</div>
                    <div class="detail-value">: {{ $datapelanggan->spCode }}</div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('data.pelanggan') }}" class="btn btn-secondary btn-sm">
                        ← Kembali
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
