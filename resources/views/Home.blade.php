@extends('layout.layout_sidebar')

@section('title', 'Dashboard')

@section('content')
<div id="exportDashboard">


<!--begin::App Content Header-->
        <div class="app-content-header" >
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-2">
                
                  <h4 class="mb-0">Dashboard</h4>
               
                
                
              </div>
              <div class="col-sm-10 d-flex justify-content-end">
                <div style="padding-top : 5px;" class="col-md-2">
                      <label  class="form-label fw-semibold ">Tanggal Mulai</label>
                      
                  </div>
                  <div class="col-md-3">
                      <input  type="date" id="tanggal_awal" class="form-control">
                  </div>
                  <div style="padding-left : 10px; padding-top : 5px;" class="col-md-2">
                      <label class="form-label fw-semibold">Tanggal Akhir</label>  
                  </div>
                  <div class="col-md-3">
                      <input type="date" id="tanggal_akhir" class="form-control">
                  </div>
                  <div class="col-md-1">
                    <div class="dropdown export-hide" style="padding-left : 10px;">
                      <button class="btn btn-light shadow-sm" data-bs-toggle="dropdown">
                          <i class="bi bi-download"></i>
                      </button>

                      <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item" href="#" onclick="downloadPDF()">
                                <i class="bi bi-file-earmark-pdf text-danger"></i> Download PDF
                            </a>
                          </li>

                          <li>
                            <a class="dropdown-item" href="#" onclick="downloadJPG()">
                                <i class="bi bi-image text-success"></i> Download JPG
                            </a>
                          </li>
                      </ul>
                    </div>
                </div>
              </div>
              
            
            <!--end::Row-->
            </div>
          </div>
          <!--end::Container-->
        </div>
        <div class="app-content" >
          <!--begin::Container-->
          <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
              <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                  <span class="info-box-icon text-bg-light shadow-sm">
                    <i class="bi bi-file-earmark-bar-graph icon-red"></i>
                  </span>

                  <div class="info-box-content">
                    <span class="info-box-text">Jumlah Ticket Bulan Ini</span>
                  
                    <span class="info-box-number" id="totalMasuk">0</span>
                    
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                  <span class="info-box-icon text-bg-light shadow-sm">
                    <i class="bi bi-file-earmark-check icon-red"></i>
                  </span>

                  <div class="info-box-content">
                    <span class="info-box-text">Solved Ticket Bulan Ini</span>
                    <span class="info-box-number" id="totalKeluar">0</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              <!-- /.col -->

              <!-- fix for small devices only -->
              <!-- <div class="clearfix hidden-md-up"></div> -->

              <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                  <span class="info-box-icon text-bg-light shadow-sm">
                    <i class="bi bi-file-earmark-check icon-red"></i>
                  </span>

                  <div class="info-box-content">
                    <span class="info-box-text">Ticket On Progress</span>
                    <span class="info-box-number" id="OnProgres">0</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>
              
            </div>
            <!-- /.row -->

            <!--begin::Row-->
            <div class="row">
              <div class="col-md-8">
                <div class="card mb-4">
                  <div class="card-header">
                    <h5 class="card-title">Grafik Ticket Semester</h5>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <!--begin::Row-->
                    <div class="row">
                      <div class="col-md-12">
                        
                        <p class="text-center">
                        <strong id="keteranganPeriode"></strong>
                        </p>
                        <div id="chartMasukKeluar"></div>
                      </div>
                    </div>
                    <!--end::Row-->
                  </div>
                  <!-- ./card-body -->
                  
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
               <div class="col-md-4">
                <div class="card mb-3">
                  <div class="card-header">
                    <h5 class="card-title">Daftar Ticket On Progress</h5>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body" style="height: 392px; overflow-y: auto;">
                    <table  class="table table-bordered " style="text-align:center;">
                        <thead>
                            <tr>
                                <th class="th-merah">Ticket</th>
                                <th class="th-merah">Tanggal</th>
                                <th class="th-merah">Status</th>
                            </tr>
                        </thead>
                        <tbody id="ticketnewTable">
                          
                        </tbody>
                    </table>
                  <div class="card-footer">
                  <div class="row">
                      <div class="col-md-12">
                        
                        <div id="pieChartKategori"></div>


                      </div>
                    </div>

                  

                    
                  </div>
                  <!-- /.card-footer -->
                </div>
                <!-- /.card -->
              </div>
            </div>
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
</div>
@endsection
