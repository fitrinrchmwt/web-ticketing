@extends('layout.layout_sidebar')

@section('title', 'Data Pelanggan')

@section('content')
<!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                <h4 class="mb-0" style="margin-left: 5px">Data Pelanggan </h4>
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
                        
                        <form method="GET" action="{{ route('data.pelanggan') }}">
                            <div class="row g-3 mb-4 mt-2 ms-2">
                                <div class="col-md-3">
                                    <label class="mb-2">Nama Pelanggan</label>
                                    <input type="text" name="custName" id="filterpelanggan" class="form-control" value="{{ request('custName') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="mb-2">CID</label>
                                    <input type="text" name="custNumber" id="filtercid" class="form-control" value="{{ request('custNumber') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="mb-2">Kode Layanan</label>
                                    <select name="spCode" id="filterJenislayanan" class="form-control form-select2" style="width: 100%;">
                                    <option value="">Pilih</option>
                                    @foreach ($kodeLayanan as $kode)
                                        <option value="{{ $kode }}"
                                            {{ request('spCode') == $kode ? 'selected' : '' }}>
                                            {{ $kode }}
                                        </option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="col-md-2 mt-5 d-flex gap-2">
                                    <!-- Cari -->
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        <i class="bi bi-search"></i>
                                    </button>

                                    <!-- Reset -->
                                    <a href="{{ route('data.pelanggan') }}" class="btn btn-secondary btn-sm">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                </div>

                            </div>
                        </form>
                        

                        <div class="row mb-2">
                            <div class="col-12 text-end pe-5">
                                <a href="{{ route('datapelanggan.sync') }}"
                                class="btn btn-success btn-sm px-3 py-1"
                                onclick="return confirm('Sinkronisasi data pelanggan dari API?')">
                                    <i class="bi bi-arrow-repeat me-1"></i> Sync Data
                                </a>
                            </div>
                        </div>
  
                        <div class="card-body" style="max-height: 700px">
                            <div class="row mb-3">
                                <div class="col-sm-5" id="tableLength"></div>
                                <div class="col-sm-7 text-end" id="tableSearch"></div>
                            </div>
                            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <!-- <div class="table-responsive"> -->
                                <table id="tabelpelanggan" class="table table-bordered table-striped text-center" width="100%"cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="th-merah">No</th>
                                            <th class="th-merah">CID</th>
                                            <th class="th-merah">Nama Pelanggan</th>
                                            <th class="th-merah">Email</th>
                                            <th class="th-merah">No WA</th>
                                            <th class="th-merah">Kode Layanan</th>
                                            <th style="width: 100px;" class="th-merah text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($datapelanggan as $pelanggan)
                                        <tr>
                                            <td>{{ $loop->iteration + ($datapelanggan->firstItem() - 1) }}</td>
                                            <td>{{ $pelanggan->custNumber }}</td>
                                            <td>{{ $pelanggan->custName ?? '-' }}</td>
                                            <td>{{ $pelanggan->custEmail ?? '-' }}</td>
                                            <td>{{ $pelanggan->custPhone ?? '-' }}</td>
                                            <td>{{ $pelanggan->spCode ?? '-' }}</td>
                                            <td class="text-center align-middle">
                                               <a href="{{ route('datapelanggan.detail', $pelanggan->custNumber) }}" class="btn btn-warning btn-sm"> Detail</a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7">Data pelanggan kosong</td>
                                        </tr>
                                        @endforelse
                                        </tbody>

                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                <div class="row align-items-center">
                                    <div class="col-sm-6">
                                        <div class="pagination-info">
                                            Menampilkan
                                            {{ $datapelanggan->firstItem() }}
                                            sampai
                                            {{ $datapelanggan->lastItem() }}
                                            dari
                                            {{ $datapelanggan->total() }}
                                            data
                                        </div>
                                    </div>

                                    <div class="col-sm-6 d-flex justify-content-end">
                                        {{ $datapelanggan->onEachSide(1)->links('pagination.cust_pagination') }}
                                    </div>
                                </div>
                            </div>



                        </div>
                        <!-- /.card -->
                    </div>
                    
                    
                   
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
$(document).on('click', '.detail-pelanggan-btn', function () {

    let custNumber = $(this).data('id');
    console.log('CustNumber:', custNumber);

    $.ajax({
        url: "{{ url('/datapelanggan/detail') }}/" + custNumber,
        type: 'GET',
        success: function (res) {
            console.log(res);

            $('#detail_id').val(res.custNumber);
            $('#detail_nama').val(res.custName);
            $('#detail_email').val(res.custEmail);
            $('#detail_add').val(res.custAddress);
            $('#detail_wa').val(res.custPhone);
            $('#detail_group').val(res.custGroupId);
            $('#detail_prov').val(res.custProvince);
            $('#detail_dist').val(res.custDistrict);
            $('#detail_sub_dist').val(res.custSubDistrict);
            $('#detail_village').val(res.custVillage);
            $('#detail_codeid').val(res.spCodeId);
            $('#detail_code').val(res.spCode);

            // Bootstrap 5 (WAJIB PAKAI INI)
            let modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        },
        error: function (xhr) {
            console.log('STATUS:', xhr.status);
            console.log('RESPONSE:', xhr.responseText);
            alert('Gagal mengambil data pelanggan');
        }

    });
});
</script>
<script>
        $(function () { 
            let table = $('#tabelpelanggan').DataTable({ 
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
    



        <!-- <script>
            // Cek apakah elemen alert ada
            const alert = document.getElementById('alert-success');
            if (alert) {
                setTimeout(() => {
                    // Hilangkan alert setelah 5 detik (5000 ms)
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 500); // hapus elemen setelah fade
                }, 5000);
            }
        </script> 
    <!-- <script>
        const editModal = document.getElementById('modalFormEditLayanan');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            document.getElementById('layanan-edit_id_layanan').value = button.getAttribute('data-id_layanan');
            document.getElementById('layanan-edit_id_departemen').value = button.getAttribute('data-id_departemen');
            document.getElementById('layanan-edit_jenis_layanan').value = button.getAttribute('data-jenis_layanan');
            document.getElementById('layanan-edit_kode_layanan').value = button.getAttribute('data-kode_layanan');
        });
    </script> -->
@endsection