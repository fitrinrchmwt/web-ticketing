@extends('layout.layout_sidebar')

@section('title', 'Kelola Pengguna')

@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0" style="margin-left: 5px">Kelola Pengguna</h4>
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
                            <div class="card-header">

                                <div class="col-md-3 ">
                                    <label>&nbsp;</label><br>
                                    <button class="btn btn-primary btn-detail-aksi float-left" data-style="expand-right"
                                        data-bs-toggle="modal" data-bs-target="#modalFormTambah"><span
                                            class="ladda-label"><i class="bi bi-plus"></i>Tambah Data</button>
                                </div>


                            </div>
                            @include('Kelola_Pengguna.Form_Tambah')
                            <div class="card-body" style="max-height: 700px">

                                <div class="row mb-3">
                                    <div class="col-sm-12 col-md-6" id="tableLength"></div>
                                    <div class="col-sm-12 col-md-6 text-end" id="tableSearch"></div>
                                </div>
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <!-- <div class="table-responsive"> -->
                                    <table id="tabelPengguna" class="table table-bordered table-striped text-center"
                                        width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="th-merah">No</th>
                                                <th class="th-merah">Username</th>
                                                <th class="th-merah">Level</th>
                                                <th class="th-merah">Nama</th>
                                                <th class="th-merah">Email</th>
                                                <th class="th-merah">Departemen</th>
                                                <th width='20%' class="th-merah">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datapengguna as $key => $pengguna)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $pengguna->username }}</td>
                                                    <td>{{ $pengguna->nama_role }}</td>
                                                    <td>{{ $pengguna->nama }}</td>
                                                    <td>{{ $pengguna->email }}</td>
                                                    <td>{{ $pengguna->nama_departemen }}</td>
                                                    <td width='20%'>
                                                        <!-- Tombol Edit -->
                                                        <button type="button"
                                                            class="btn btn-success btn-sm mb-2 text-white pengguna-edit-btn"
                                                            data-bs-toggle="modal" data-bs-target="#modalFormEdit"
                                                            data-id_pengguna="{{ $pengguna->id_pengguna }}"
                                                            data-id_departemen="{{ $pengguna->id_departemen }}"
                                                            data-id_role="{{ $pengguna->id_role }}"
                                                            data-nama="{{ $pengguna->nama }}"
                                                            data-username="{{ $pengguna->username }}"
                                                            data-email="{{ $pengguna->email }}">
                                                            <i class="bi bi-pencil-square"></i> Edit
                                                        </button>

                                                        <!-- Tombol Hapus -->
                                                        <form action="{{ route('pengguna.delete', $pengguna->id_pengguna) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm mb-2"
                                                                onclick="return confirm('Yakin ingin menghapus Data Pengguna ini?')">
                                                                <i class="bi bi-trash-fill"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
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
                                const buttons = document.querySelectorAll('.pengguna-edit-btn');

                                buttons.forEach(button => {
                                    button.addEventListener('click', function () {
                                        document.getElementById('edit_id_pengguna').value = this.dataset.id_pengguna;
                                        document.getElementById('edit_id_departemen').value = this.dataset.id_departemen;
                                        document.getElementById('edit_id_role').value = this.dataset.id_role;
                                        document.getElementById('edit_nama').value = this.dataset.nama;
                                        document.getElementById('edit_username').value = this.dataset.username;
                                        document.getElementById('edit_email').value = this.dataset.email;
                                    });
                                });
                            });
                        </script>
                        @include('Kelola_Pengguna.Form_Edit')
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
                let table = $('#tabelPengguna').DataTable({
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

        <script>
            function togglePassword(id, btn) {
                const input = document.getElementById(id);
                const icon = btn.querySelector("i");
                if (input.type === "password" ) {
                    input.type = "text";
                    icon.classList.remove("bi-eye-slash");
                    icon.classList.add("bi-eye");
                } else {
                    input.type = "password";
                    icon.classList.remove("bi-eye");
                    icon.classList.add("bi-eye-slash");
                }
            }
        </script>
    @endsection