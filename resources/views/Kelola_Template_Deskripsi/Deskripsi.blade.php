@extends('layout.layout_sidebar')

@section('title', 'Kelola Template Deskripsi')

@section('content')
<!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                <h4 class="mb-0" style="margin-left: 5px">Kelola Template Deskripsi</h4>
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
                                <button class="btn btn-primary btn-detail-aksi float-left" data-style="expand-right" data-bs-toggle="modal" data-bs-target="#modalFormTambahDeskripsi"><span class="ladda-label"><i class="bi bi-plus"></i>Tambah Data</button>
                            </div>
                            
                            
                        </div>
                        @include('Kelola_Template_Deskripsi.Form_Tambah')
                        
                        <div class="card-body" style="max-height: 700px">
                            
                            <div class="row mb-3">
                                <div class="col-sm-12 col-md-6" id="tableLength"></div>
                                <div class="col-sm-12 col-md-6 text-end" id="tableSearch"></div>
                            </div>
                            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <!-- <div class="table-responsive"> -->
                                <table id="tabelDeskripsi" class="table table-bordered table-striped text-center"  width="100%"cellspacing="0">
                                    <thead >
                                        <tr>
                                            <th class="th-merah">No</th>
                                            <th class="th-merah">Label</th>
                                            <th class="th-merah">Deskripsi</th>
                                            <th width='20%' class="th-merah">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datades as $key => $deskripsi)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td>{{$deskripsi -> label_deskripsi}}</td>
                                                <td>@php
                                                        $teks = $deskripsi->deskripsi ?? ''; 

                                                        
                                                        if (preg_match('/<p.*?<\/p>/i', $teks, $matches)) {
                                                            $isi = $matches[0];
                                                        } else {
                                                            $isi = ''; // kalau gak ada <p>
                                                        }
                                                    @endphp 
                                                    {!! $isi !!}</td>
                                                <td width='20%'>
                                                    <button type="button" class="btn btn-success btn-sm mb-2 edit-deskripsi-btn" data-bs-toggle="modal" data-bs-target="#modalFormEditDeskripsi"
                                                    data-id_deskripsi="{{ $deskripsi->id_deskripsi}}"
                                                    data-label_deskripsi="{{ $deskripsi->label_deskripsi}}"
                                                    data-deskripsi="{{ $deskripsi->deskripsi}}">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </button>
                                                    <form action="{{ route('deskripsi.delete', $deskripsi->id_deskripsi) }}" method="POST"
                                                            style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm mb-2"
                                                                data-bs-toggle="modal" data-bs-target="#hapusDeskripsiModal"
                                                                onclick="return confirm('Yakin ingin menghapus Template Deskripsi ini?')">
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
                            const buttons = document.querySelectorAll('.edit-deskripsi-btn');

                            buttons.forEach(button => {
                                button.addEventListener('click', function () {
                                    document.getElementById('edit_id_deskripsi').value = this.dataset.id_deskripsi;
                                    document.getElementById('edit_label_deskripsi').value = this.dataset.label_deskripsi;
                                    $('#edit_deskripsi').summernote('code', this.dataset.deskripsi);
                                });
                            });
                            
                        });
                    </script>
                    @include('Kelola_Template_Deskripsi.Form_Edit')
                </div>
              
            </div>
            <!-- /.row -->

           
              
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
@endsection
@section('script')
<script>
        $(function () { 
            let table = $('#tabelDeskripsi').DataTable({ 
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
        $(document).ready(function() {

            // SUMMERNOTE CREATE
            $('#deskripsi').summernote({
                height: 200,
                placeholder: 'Tulis deskripsi di sini...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        uploadImage(files[0], '#deskripsi');
                    }
                }
            });

            // SUMMERNOTE EDIT
            $('#edit_deskripsi').summernote({
                height: 200,
                placeholder: 'Tulis deskripsi di sini...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        uploadImage(files[0], '#edit_deskripsi');
                    }
                }
            });

            // FUNCTION UPLOAD — FIX
            function uploadImage(file, selector) {
                let data = new FormData();
                data.append("file", file);

                $.ajax({
                    url: "{{ route('summernote.upload') }}",
                    type: "POST",
                    data: data,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $(selector).summernote('insertImage', response.url);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }

        });
    </script>
    
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    
@endsection