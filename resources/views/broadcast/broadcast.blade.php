@extends('layout.layout_sidebar')

@section('title', 'broadcast')

@section('content')

<style>

#tablePagination {
    display: flex;
    justify-content: flex-end;
}

#tablePagination .dataTables_paginate {
    float: none !important;
}

#tablePagination .pagination {
    margin: 0;
}

#tableLength .dataTables_length {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    white-space: nowrap;
}

#tableLength .dataTables_length select {
    width: 70px !important;
    display: inline-block !important;
    margin: 0 5px !important;
}

#tableLength .dataTables_length label {
    margin: 0 !important;
    display: flex !important;
    align-items: center !important;
    gap: 6px;
}

#tableSearch .dataTables_filter {
    width: 100% !important;
    display: flex !important;
    justify-content: flex-end !important;
    align-items: center !important;
    gap: 8px;
}

#tableSearch .dataTables_filter label {
    display: flex !important;
    align-items: center !important;
    margin: 0 !important;
}

#tableSearch .dataTables_filter input {
    height: 30px !important;
    margin: 0 !important;
}

</style>

<!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                <h4 class="mb-0">Broadcast WhatsApp</h4>
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
                        <div class="row g-3 mb-4 mt-2 ms-2">
                            <div class="col-md-2">
                                <label class="mb-2 ">Kode Layanan</label>
                                <select id="filterlayanan" class="form-control">
                                    <option value="">Pilih Kode</option>
                                    @foreach ($kodeLayanan as $kode)
                                        <option value="{{ $kode }}">{{ $kode }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mt-5 gap-2">
                                <button id="btnFilter" type="button" class="btn btn-warning">
                                    <i class="bi bi-search">Cari</i>
                                </button>

                                <button id="btnReset" type="button" class="btn btn-secondary">
                                    <i class="bi bi-arrow-counterclockwise">Reset</i>
                                </button>
                            </div>
                            
                            <div class="col-md-6 mt-5 text-end">
                                {{--menyembunyikan tombol--}}
                                <div id="tombolPesan" style="display: none;">
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalPesan">
                                        <i class="fas fa-comment-dots"></i> Isi Pesan
                                    </button>
                                </div>
                            </div>
                        </div>
                            
                        <div class="card-body" style="max-height: 700px">
                            
                            <div class="row mb-3">
                                <div class="col-md-5" id="tableLength"></div>
                                <div class="col-md-7 text-end" id="tableSearch"></div>
                            </div>
                            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                <table id="tablebroadcast" class="table table-bordered table-striped text-center" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="th-merah">No</th>
                                            <th class="th-merah">CID</th>
                                            <th class="th-merah">Nama broadcast</th>
                                            <th class="th-merah">No WA</th>
                                            <th width="20%" class="th-merah">
                                                <input type="checkbox" id="checkAll"> Pilih Semua</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <!-- </div> -->
                             @include('broadcast.form_pesan')
                        </div>
                        <!-- /.card -->
                        <div class="card-footer clearfix">
                            <div class="row">
                                <div class="col-sm-6" id="tableInfo"></div>
                                <div class="col-md-6 text-end" id="tablePagination"></div>
                            </div>
                        </div>
                    
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
(function () {
    let selectedCustomers = {};
    let selectAllGlobal = false;

    $(document).ready(function () {
        const tombolPesan = $('#tombolPesan');

        function toggleTombol() {
            tombolPesan.toggle(
                selectAllGlobal || Object.keys(selectedCustomers).length > 0
            );
        }

        // pilih semua
        $('#tablebroadcast').on('change', '#checkAll', function () {
            selectAllGlobal = this.checked;

            if (selectAllGlobal) {
                selectedCustomers = {};
            }

            $('.row-check').prop('checked', this.checked);
            toggleTombol();
        });

        // perbaris
        $('#tablebroadcast').on('change', '.row-check', function () {
            let id = $(this).val();

            if (this.checked) {
                selectedCustomers[id] = {
                    name: $(this).data('name'),
                    phone: $(this).data('phone')
                };
            } else {
                delete selectedCustomers[id];
                selectAllGlobal = false;
                $('#checkAll').prop('checked', false);
            }

            toggleTombol();
        });

        $('#tablebroadcast').on('draw.dt', function () {
            if (selectAllGlobal) {
                $('.row-check').prop('checked', true);
                $('#checkAll').prop('checked', true);
            } else {
                $('.row-check').each(function () {
                    if (selectedCustomers[$(this).val()]) {
                        $(this).prop('checked', true);
                    }
                });
            }
            toggleTombol();
        });

        // modal
        $('#modalPesan').on('show.bs.modal', function () {
            let tbody = $('#listPelanggan');
            let container = $('#custNumberContainer');

            tbody.empty();
            container.empty();

            if (selectAllGlobal) {
                tbody.append(`
                    <tr>
                        <td colspan="2" class="text-center fw-bold text-success">
                            Semua pelanggan akan menerima pesan
                        </td>
                    </tr>
                `);
                container.append(`<input type="hidden" name="select_all" value="1">`);
                return;
            }

            let entries = Object.entries(selectedCustomers);

            if (entries.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="2" class="text-center text-muted">
                            Belum ada pelanggan dipilih
                        </td>
                    </tr>
                `);
                return;
            }

            entries.forEach(([id, data]) => {
                tbody.append(`
                    <tr>
                        <td>${data.name}</td>
                        <td>${data.phone}</td>
                    </tr>
                `);

                container.append(`
                    <input type="hidden" name="custNumber[]" value="${id}">
                `);
            });
        });
    });
})();
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('templateSelect');
        const textarea = document.getElementById('isiPesan');

        select.addEventListener('change', function () {
            const option = this.options[this.selectedIndex];
            let isi = option.dataset.content || '';

            if (!this.value) {
                textarea.value = '';
                textarea.setAttribute('readonly', true);
                textarea.removeAttribute('disabled');
                textarea.classList.add('bg-light');
                textarea.placeholder = 'Pilih template terlebih dahulu';
                return;
            }

            const txt = document.createElement('textarea');
            txt.innerHTML = isi;
            isi = txt.value;

            textarea.value = isi;
            textarea.focus();
        });
    });
</script>


<script>
    $(function () {
        let table = $('#tablebroadcast').DataTable({
            processing: false,
            serverSide: true, 
            searching: true, 
            ordering: false,

            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],

            ajax: {
                url: "{{ route('broadcast.data') }}",
                data: function (d) {
                    d.layanan = $('#filterlayanan').val();
                }
            },

            initComplete: function () {
                $('#tablebroadcast_length select')
                    .removeClass('custom-select custom-select-sm')
                    .addClass('form-select form-select-sm d-inline-block w-auto');
            },

            columns: [
                {
                    data: null,
                    render: (d, t, r, m) => m.row + m.settings._iDisplayStart + 1
                },
                { data: 'custNumber' },
                { data: 'custName' },
                { data: 'custPhone' },
                {
                    data: null,
                    orderable: false,
                    render: data => `
                        <input type="checkbox"
                            class="row-check"
                            value="${data.custNumber}"
                            data-name="${data.custName}"
                            data-phone="${data.custPhone}">
                    `
                }
            ],

            language: {
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    previous: "‹‹",
                    next: "››"
                }
            },

            dom:
            "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + 
            "tr" + 
            "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>" 

        });
        table.on('init', function () {
            $('#tablebroadcast_length').appendTo('#tableLength');
            $('#tablebroadcast_filter').appendTo('#tableSearch');
            $('#tablebroadcast_info').appendTo('#tableInfo');
            $('#tablebroadcast_paginate').appendTo('#tablePagination');
        });

        table.on('draw', function () {
            $('#tableInfo').html($('.dataTables_info'));
            $('#tablePagination').html($('.dataTables_paginate'));
        });


        // filter
        $('#btnFilter').on('click', function () {
            table.ajax.reload();
        });
        $('#btnReset').on('click', function () {
        $('#filterlayanan').val('');
        table.search('').draw();   
        table.ajax.reload();       
        });

        // search 
        $('#tablebroadcast_filter input')
        .off('keyup')
        .on('keyup', function () {
            table.search(this.value).draw();
        });
 
    });
</script>
@endsection
