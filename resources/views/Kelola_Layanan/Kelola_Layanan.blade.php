@extends('layout.layout_sidebar')

@section('title', 'Kelola Layanan')

@section('content')
<!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                <h4 class="mb-0" style="margin-left: 5px">Kelola Layanan</h4>
              </div>
            <!--end::Row-->
            
          </div>
          <!--end::Container-->
        </div>
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body" style="max-height: 700px">
                            <div class="row mb-3">
                                <div class="col-sm-5" id="tableLength"></div>
                                <div class="col-sm-7 text-end" id="tableSearch"></div>
                            </div>
                            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                <table  id="tabelLayanan" class="table table-bordered table-striped text-center" width="100%"cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="th-merah">No</th>
                                            <th class="th-merah">ID Layanan</th>
                                            <th class="th-merah">Layanan</th>
                                            <th class="th-merah">Kode Layanan</th>
                                            <th width='20%' class="th-merah">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- API LAYANAN -->
                                        @if(is_array($datalayanan) && count($datalayanan) > 0)
                                            @foreach ($datalayanan as $key => $layanan)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $layanan['spCodeId'] ?? '-' }}</td>
                                                    <td>{{ $layanan['spName'] ?? '-' }}</td>
                                                    <td>{{ $layanan['spCode'] ?? '-' }}</td>
                                                    <td width='20%'>
                                                        <button type="button" class="btn btn-warning btn-sm mb-2 detail-layanan-btn" data-bs-toggle="modal" data-bs-target="#modalFormEdit"
                                                        data-id_layanan="{{ $layanan['spCodeId'] ?? '-'}}"
                                                        data-jenis_layanan="{{ $layanan['spName'] ?? '-'}}"
                                                        data-kode_layanan="{{ $layanan['spCode'] ?? '-'}}"
                                                        data-price="{{ $layanan['spPrice'] ?? '-'}}">
                                                            <i class="bi bi-file-earmark-text"></i> Detail
                                                        </button>
                                                        
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                             <tr>
                                                <td colspan="3">Data layanan kosong / tidak terbaca</td>
                                            </tr>
                                        @endif
                                        <!-- API LAYANAN -->
                                    </tbody>
                                </table>
                            </div>
                            <!-- </div> -->
                            <div class="card-footer clearfix">
                                <div class="row">
                                    <div class="col-sm-8" id="tableInfo"></div>
                                    <div class="col-sm-4" id="tablePagination"></div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card -->
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const buttons = document.querySelectorAll('.detail-layanan-btn');

                            buttons.forEach(button => {
                                button.addEventListener('click', function () {
                                    document.getElementById('detail_id_layanan').value = this.dataset.id_layanan;
                                    document.getElementById('detail_jenis_layanan').value = this.dataset.jenis_layanan;
                                    document.getElementById('detail_kode_layanan').value = this.dataset.kode_layanan;
                                    document.getElementById('detail_price').value = this.dataset.price;
                                });
                            });
                        });
                    </script>
                    
                    @include('Kelola_Layanan.Form_Detail')
                </div>
              
            </div>
            <!-- /.row -->

           
              
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
@endsection
@section('modal')
@endsection
@section('script')
<script>
            $(function () { 
                let table = $('#tabelLayanan').DataTable({ 
                    responsive: false, 
                    lengthChange: true, 
                    autoWidth: false, 
                    pagingType: "simple_numbers", 
                    language: { 
                        paginate: { 
                            previous: "&laquo;", 
                            next: "&raquo;" 
                        }, 
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data", 
                        infoEmpty: "Tidak ada data", 
                    }, 
                    dom: 
                    "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + 
                    "tr" + 
                    "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>" 
                    }); 
                    $('#tableLength').append($('.dataTables_length').detach());
                    $('#tableSearch').append($('.dataTables_filter').detach());
                    
                    $('#tableInfo').append($('.dataTables_info')); 
                    $('#tablePagination').append($('.dataTables_paginate'));

                    $('.dataTables_length select').addClass('form-select form-select-sm mx-2'); 
                    $('.dataTables_filter input').addClass('form-control form-control-sm ms-2'); 
                    $('.dataTables_length label, .dataTables_filter label').addClass('d-inline-flex align-items-center');

                    $('.dataTables_paginate ul').addClass('pagination pagination-sm m-0 float-end'); 
                    $('.dataTables_paginate li').addClass('page-item'); 
                    $('.dataTables_paginate a').addClass('page-link');
                }); 
        </script>
@endsection
