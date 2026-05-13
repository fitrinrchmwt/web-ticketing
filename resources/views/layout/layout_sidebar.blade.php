<!DOCTYPE html>
<html lang="id">
<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title') | Life Media </title>
  <link rel="icon" type="image/x-icon" href="{{ asset('asset/img/favicon.png') }}">
  <!-- Google Font: Source Sans Pro -->
  <!--begin::Accessibility Meta Tags-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  <meta name="color-scheme" content="light dark" />
  <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
  <!-- <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" /> -->
  <!--end::Accessibility Meta Tags-->

  <!--begin::Primary Meta Tags-->
  <meta name="title" content="AdminLTE | Dashboard v2" />
  <meta name="author" content="ColorlibHQ" />
  <meta name="description"
    content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance." />
  <meta name="keywords"
    content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant" />
  <!--end::Primary Meta Tags-->
  <!-- Skip links will be dynamically added by accessibility.js -->
  <meta name="supported-color-schemes" content="light dark" />
  <link rel="stylesheet" href="{{ asset('asset/dist/css/adminlte.css') }}" as="style" />
  <!--end::Accessibility Features-->

  <!--begin::Fonts-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
    integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" media="print"
    onload="this.media='all'" />
  <!--end::Fonts-->

  <!--begin::Third Party Plugin(OverlayScrollbars)-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
    crossorigin="anonymous" />
  <!--end::Third Party Plugin(OverlayScrollbars)-->

  <!--begin::Third Party Plugin(Bootstrap Icons)-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!--end::Third Party Plugin(Bootstrap Icons)-->

  <!--begin::Required Plugin(AdminLTE)-->
  <link rel="stylesheet" href="{{ asset('asset/dist/css/adminlte.css') }}" />
  <!--end::Required Plugin(AdminLTE)-->

  <!-- apexcharts -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
    integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous" />


  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <style>
    input[type="date"] {
      color-scheme: light;
    }

    .icon-green {
      color: green;
      font-size: 24px;
      /* atur ukuran */
      -webkit-text-stroke: 1px #000;
      /* bikin garis luar (biar tebal) */
    }

    .icon-orange {
      color: orange;
      font-size: 24px;
      -webkit-text-stroke: 0.5px #000;
    }

    .icon-red {
      background: linear-gradient(90deg, rgba(155, 34, 68, 1) 0%, rgba(221, 68, 112, 1) 100%);
      font-size: 30px;
      -webkit-text-stroke: 0.75px transparent;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .export-mode .icon-red{
    background:none !important;
    -webkit-text-fill-color:#dc3545 !important;
    color:#dc3545 !important;
}
.export-mode .export-hide{
    display:none !important;
}
.export-mode .export-hide{
    display:none !important;
}
    .daterangepicker .ranges li.active {
      background-color: #9B2244 !important;
      /* merah contoh */
      color: #fff !important;
    }

    .btn-custom {
      background-color: #9B2244 !important;
      /* merah contoh */
      color: #fff !important;
    }

    .btn-warning {
      color: #fff !important;
    }

    .btn-info {
      color: #fff !important;
    }


    .text-bg-primary {
      background-color: #000080 !important;
      border-color: #000080 !important;
    }
     .small-box .icon {
    font-family: "Font Awesome 5 Free";
}
.info-box-icon{
    background-color: white !important;
}
.icon-box-white{
    background:#ffffff !important;
    border-radius:10px;
}

.info-box-icon i{
    font-size: 30px;
    color:#dc3545 !important;
  
}

    .loader-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(237, 237, 237, 0.85);
      /* display: flex; */
      align-items: center;
      justify-content: center;
      z-index: 9999;
      display: none;
    }

    .loader-content {
      text-align: center;
      color: #555;
    }

    .loader-logo {
      width: 50%;
      animation: pulse 1.2s infinite ease-in-out;
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
        opacity: 0.8;
      }

      50% {
        transform: scale(1.1);
        opacity: 1;
      }

      100% {
        transform: scale(1);
        opacity: 0.8;
      }
    }

    .bg-biru {
      background-color: #54A5FA !important;
      /* biru muda*/
      color: #fff !important;
    }

    :root,
    [data-bs-theme=light] {
      --lte-sidebar-width: 240px !important;
      /* bebas mau berapa */
    }
    
    .select2-container--default .select2-selection--single .select2-selection__clear {
    color: black !important;
    margin-right: 5px;
    margin-left: 5px;
}


    .btn-close.white {
      filter: invert(1) brightness(200%);
    }

    .info-box {
      transition:
        transform 0.3s ease,
        background-color 0.1s ease,
        color 0.3s ease,
        box-shadow 0.3s ease !important;
    }

    .info-box:hover {
      transform: translateY(-10px);
      background-color: rgba(221, 68, 112, 1);
      /* warna berubah */
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .info-box-icon i {
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

    .info-box:hover .icon-box i {
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


    .th-merah {
      text-align: center !important;
      vertical-align: middle !important;
      background-color: #9B2244 !important;
      color: #fff !important;
    }

    .note-editor.note-frame.fullscreen {
      background-color: white;
    }

    .note-editor .dropdown-toggle::after {
      all: unset;
    }

    .note-editor .note-dropdown-menu {
      box-sizing: content-box;
    }

    .note-editor .note-modal-footer {
      box-sizing: content-box;
    }


    .select2-container--default .select2-search--dropdown .select2-search__field {
    background-color: #fff;
}

    
        .select2-results__options {
            scrollbar-width: thin;
            scrollbar-color: #606960ff #f1f1f1; /* Thumb putih, Track abu-abu terang */
        }

        /* Webkit (Chrome, Safari, Edge) */
        .select2-results__options::-webkit-scrollbar {
            width: 8px; /* Lebar scrollbar */
        }

        /* Jalur scrollbar (Track) */
        .select2-results__options::-webkit-scrollbar-track {
            background: #f1f1f1; /* Warna abu-abu terang agar thumb putih terlihat */
            border-radius: 4px;
        }

        /* Batang scrollbar (Thumb) */
        .select2-results__options::-webkit-scrollbar-thumb {
            background-color: #ffffff; /* Warna utama: Putih */
            border-radius: 4px;
            border: 1px solid #dcdcdc; /* Garis tepi tipis agar tidak menyatu dengan background putih */
        }

        /* Saat kursor diarahkan ke scrollbar */
        .select2-results__options::-webkit-scrollbar-thumb:hover {
            background-color: #e9e9e9;
        }
       
  </style>
</head>
@php
  use Illuminate\Support\Facades\Session;
  use App\Models\PenggunaModel;

  $user = null;
  if (Auth::check()) {
    $pengguna = PenggunaModel::with('role')->find(Auth::id());
    $pengguna = PenggunaModel::with('departemen')->find(Auth::id());
  }
@endphp

<body class="layout-fixed fixed-header sidebar-expand-lg sidebar-mini bg-body-tertiary">

  <!--begin::App Wrapper-->
  <div class="app-wrapper">
    <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
              <i class="bi bi-list"></i>
            </a>
          </li>
        </ul>
        <!--end::Start Navbar Links-->

        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
          <!--begin::Notifications Dropdown Menu-->

          <!--end::Notifications Dropdown Menu-->


          <!--begin::User Menu Dropdown-->
          <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
              <!-- Foto profil -->
              <i class="bi bi-person-circle fs-2 shadow me-2"></i>


              <!-- Nama dan Departemen -->
              <div class="d-flex flex-column text-start">
                <span class="fw-semibold">
                  {{ $pengguna ? $pengguna->username : 'Tamu' }}
                </span>
                <small class="text-muted" style="line-height: 1;">
                  {{ $pengguna && $pengguna->departemen ? $pengguna->departemen->nama_departemen : '-' }}-{{ $pengguna && $pengguna->role ? $pengguna->role->nama_role : '-' }}
                </small>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown"
              style="max-width: 50px;">
              <a href="#" class="dropdown-item" onclick="event.preventDefault(); 
                    if (confirm('Yakin ingin logout?')) {
                        document.getElementById('logout-form').submit();
                    }">
                <i class="fas bi-box-arrow-right mr-2 text-gray-400"></i>
                Logout
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>

            </div>
          </li>
          <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
      </div>
      <!--end::Container-->
    </nav>
    <!--end::Header-->
    <!--begin::Sidebar-->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
      <!--begin::Sidebar Brand-->
      <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="./index.html" class="brand-link">

          <!--begin::Brand Image-->
          <img src="{{ asset('asset/img/logo.svg') }}" alt="Logo" class="brand-image opacity-75 shadow" />
          <!--end::Brand Image-->
          <!--begin::Brand Text-->
          <span class="brand-text fw-light"><img src="{{ asset('asset/img/favicon.png') }}" alt="Logo"
              class="brand-image" style="display: none;"></span>
          <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
      </div>
      <!--end::Sidebar Brand-->
      <!--begin::Sidebar Wrapper-->
      <div class="sidebar-wrapper">
        <nav class="mt-2">
          <!--begin::Sidebar Menu-->
          <ul class="nav sidebar-menu nav-pills nav-sidebar flex-column" data-lte-toggle="treeview" role="navigation"
            aria-label="Main navigation" data-accordion="false" id="navigation">
            @if ($pengguna->hasPermission('dashboard'))
              <li class="nav-item">
                <a href="{{ url('home') }}" class="nav-link">
                  <i class="nav-icon bi bi-columns-gap"></i>
                  <p>Dashboard</p>
                </a>
              </li>
            @endif

            @if($pengguna->hasPermission('report'))
              <li class="nav-item">
                <a href="{{ url('report') }}" class="nav-link">
                  <i class="nav-icon bi bi-bar-chart-fill"></i>
                  <p>Report</p>
                </a>
              </li>
            @endif


            @if($pengguna->hasPermission('data_master'))
              <li
                class="nav-item has-treeview {{ request()->is('kelolakategori') || request()->is('kelolalayanan') || request()->is('kelolatemplate') || request()->is('kelola_template_deskripsi') || request()->is('keloladepartemen') || request()->is('kelolapengguna') || request()->is('kelolastatus') || request()->is('kelolarole') || request()->is('kelolasubject') ? 'menu-open' : '' }}">
                <a href="#"
                  class="nav-link {{ request()->is('kelolakategori') || request()->is('kelolalayanan') || request()->is('kelolatemplate') || request()->is('kelola_template_deskripsi') || request()->is('keloladepartemen') || request()->is('kelolapengguna') || request()->is('kelolastatus') || request()->is('kelolarole') || request()->is('kelolasubject') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-gear" aria-hidden="true"></i>
                  <p>
                    Data Master
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('keloladepartemen') }}"
                      class="nav-link {{ request()->is('keloladepartemen') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-building"></i>
                      <p>Master Departemen</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('kelolarole') }}" class="nav-link {{ request()->is('kelolarole') ? 'active' : '' }} ">
                      <i
                        class="nav-icon bi {{ request()->is('kelolarole') ? 'bi-shield-lock-fill' : 'bi-shield-lock' }}"></i>
                      <p>Master Role</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('kelolapengguna') }}"
                      class="nav-link {{ request()->is('kelolapengguna') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-person-plus"></i>
                      <p>Master Pengguna</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('kelolastatus') }}"
                      class="nav-link {{ request()->is('kelolastatus') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-check-square"></i>
                      <p>Master Status Ticket</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('kelolakategori') }}"
                      class="nav-link {{ request()->is('kelolakategori') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-grid"></i>
                      <p>Master Kategori Ticket</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('kelolalayanan') }}"
                      class="nav-link {{ request()->is('kelolalayanan') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-tools"></i>
                      <p>Master Layanan</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('kelolatemplate') }}"
                      class="nav-link {{ request()->is('kelolatemplate') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-journal"></i>
                      <p>Master Template</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('kelolasubject') }}"
                      class="nav-link {{ request()->is('kelolasubject') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-journal"></i>
                      <p>Master Subject</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('kelola_template_deskripsi') }}"
                      class="nav-link {{ request()->is('kelola_template_deskripsi') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-journal"></i>
                      <p>Master Deskripsi</p>
                    </a>
                  </li>
                </ul>
              </li>
            @endif

            @if($pengguna->hasPermission('ticket'))
              <li class="nav-item">
                <a href="{{ url('dashboard-ticket') }}"
                  class="nav-link {{ request()->is('dashboard-ticket') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-ticket-perforated"></i>
                  <p>
                    Ticket
                  </p>
                </a>
              </li>
            @endif

            @if($pengguna->hasPermission('data_pelanggan'))
              <li class="nav-item">
                <a href="{{ url('datapelanggan') }}" class="nav-link">
                  <i class="nav-icon bi bi-person-lines-fill"></i>
                  <p>
                    Data Pelanggan
                  </p>
                </a>
              </li>
            @endif
            @if($pengguna->hasPermission('broadcast'))
              <li class="nav-item">
                <a href="{{ url('broadcast') }}" class="nav-link">
                  <i class="nav-icon bi bi-broadcast"></i>
                  <p>
                    Broadcast
                  </p>
                </a>
              </li>
            @endif
          </ul>
          <!--end::Sidebar Menu-->
        </nav>
      </div>
      <!--end::Sidebar Wrapper-->
    </aside>
    <!--end::Sidebar-->
    <!--begin::App Main-->
    <main class="app-main">

      @yield('content')
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      @if (session('success'))
        <div id="alert-success" class="alert alert-success alert-dismissible fade show d-none" role="alert">
          <span id="alert-message"></span>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
          Swal.fire({
            title: 'Sukses!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#9B2244'
          });
        </script>
      @endif

      @if (session('error'))
        <div id="alert-danger" class="alert alert-danger alert-dismissible fade show d-none" role="alert">

          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
          Swal.fire({
            title: 'Gagal!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#9B2244'

          });
        </script>
      @endif
    </main>
    <!--end::App Main-->
    <!--begin::Footer-->
    <footer class="app-footer" style="display: flex; justify-content: center; align-items: center; height: 60px;">

      <!--begin::Copyright-->
      <strong>
        Copyright &copy; 2014-2026&nbsp;
        <a href="" class="">Life Media</a>.
      </strong>
      <!--end::Copyright-->
    </footer>
    <!--end::Footer-->
  </div>
  <!--end::App Wrapper-->
  <!-- Loader -->
  <div id="loader" class="loader-overlay">
    <div class="loader-content">
      <img src="{{ asset('asset/img/logo.png') }}" alt="Logo" class="loader-logo">
    </div>
  </div>
  <!--begin::Script-->
  <!--begin::Third Party Plugin(OverlayScrollbars)-->

  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
    crossorigin="anonymous"></script>
  <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>


  <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
  <script src="{{ asset('asset/dist/js/adminlte.js') }}"></script>
  <script src="{{ asset('asset/plugins/toastr/toastr.min.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- Bootstrap 5 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables -->
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

  <!-- DataTables JS -->
  @yield('script')



  <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
  <script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
      scrollbarTheme: 'os-theme-light',
      scrollbarAutoHide: 'leave',
      scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function () {
      const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);

      // Disable OverlayScrollbars on mobile devices to prevent touch interference
      const isMobile = window.innerWidth <= 992;

      if (
        sidebarWrapper &&
        OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
        !isMobile
      ) {
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
          scrollbars: {
            theme: Default.scrollbarTheme,
            autoHide: Default.scrollbarAutoHide,
            clickScroll: Default.scrollbarClickScroll,
          },
        });
      }
    });
  </script>
  <!--end::OverlayScrollbars Configure-->

  <!-- OPTIONAL SCRIPTS -->

  <!-- apexcharts -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
    integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>

  

  <script type="text/javascript">
    $(function () {
      var current = location.pathname;
      $('.nav-sidebar li a').each(function () {
        var $this = $(this);
        // if the current path is like this link, make it active
        if ($this.attr('href').indexOf(current) !== -1) {
          $this.addClass('active');
        }
      })
    })
  </script>

 <!-- CHART DASHBOARD YG FIX DIPAKEK -->
  <script>
      document.addEventListener('DOMContentLoaded', function() {
          const inputAwal = document.getElementById('tanggal_awal');
          const inputAkhir = document.getElementById('tanggal_akhir');
          const chartContainer = document.querySelector("#chartMasukKeluar");
          const infoPeriode = document.getElementById('keteranganPeriode');
          let chart = null;

          function formatTanggal(tgl) {
              return new Date(tgl).toLocaleDateString('id-ID', {
                  day: 'numeric',
                  month: 'long',
                  year: 'numeric'
              });
          }

          // === Fungsi ambil data dari Controller ===
          function loadChart(tanggalAwal = '', tanggalAkhir = '') {
              let url = "{{ route('chart.data') }}";

              if (tanggalAwal && tanggalAkhir) {
                  url += `?tanggal_awal=${tanggalAwal}&tanggal_akhir=${tanggalAkhir}`;
              }

              fetch(url)
                  .then(response => response.json())
                  .then(data => {
                      document.getElementById('totalMasuk').innerText = data.totalMasuk ?? 0;
                      document.getElementById('totalKeluar').innerText = data.totalKeluar ?? 0;
                      document.getElementById('OnProgres').innerText = data.OnProgres ?? 0;

                      let tbody = document.getElementById('ticketnewTable');
                      tbody.innerHTML = '';

                      if (data.ticketnew.length === 0) {
                          tbody.innerHTML = `
                              <tr>
                                  <td colspan="3" class="text-center">Tidak ada data</td>
                              </tr>
                          `;
                      } else {
                          data.ticketnew.forEach(ticket => {
                              tbody.innerHTML += `
                                  <tr>
                                      <td style="font-size: 13px; ">${ticket.id_ticket}</td>
                                      <td style="font-size: 13px !important;">${ticket.created_at_formatted}</td>
                                      <td>
                                          <span class="badge bg-biru" >${ticket.nama_status}</span>
                                      </td>
                                  </tr>
                              `;
                          });
                      }

                      
                      

                      const infoPeriode = document.getElementById('keteranganPeriode');

                      if (tanggalAwal && tanggalAkhir) {
                          const awal = new Date(tanggalAwal);
                          const akhir = new Date(tanggalAkhir);
                          infoPeriode.innerText = `Periode: ${formatTanggal(awal)} – ${formatTanggal(akhir)}`;
                      } else {
                          // tampilkan periode dari backend (misal: Semester 1 / 2)
                          if (data.periode) {
                              infoPeriode.innerText = `Periode: ${data.periode}`;
                          } else {
                              infoPeriode.innerText = 'Periode: Semester Aktif';
                          }
                      }

                      // === Tentukan tipe x-axis berdasarkan mode ===
                      const xaxisType = data.mode === 'daily' ? 'category' : 'category';

                      // === Konfigurasi grafik ===
                      const chartOptions = {
                          series: [
                            { name: 'Jumlah Semua Ticket', data: data.masuk },
                              { name: 'Jumlah Ticket Downtime', data: data.keluar }
                          ],
                          chart: {
                              type: 'area',
                              height: 286,
                              toolbar: { show: false }
                          },
                          legend: { show: false },
                          colors: ['#F28BAA', '#FF4313'],
                          dataLabels: { enabled: false },
                          stroke: { curve: 'smooth', width: 2 },
                          fill: {
                              type: "gradient",
                              gradient: {
                                  shadeIntensity: 1,
                                  opacityFrom: 0.4,
                                  opacityTo: 0.1,
                                  stops: [0, 90, 100]
                              }
                          },
                          xaxis: {
                              type: xaxisType,
                              categories: data.labels,
                              labels: {
                                  rotate: -45,
                                  style: { colors: '#888', fontSize: '12px' },
                                  formatter: function(value) {
                                      return value; // tampilkan label sesuai format dari controller
                                  }
                              }
                          },
                          yaxis: {
                              min: 0,
                              labels: {
                                  style: { colors: '#888', fontSize: '12px' },
                                  formatter: function (val) {
                                      return Math.round(val); // tampilkan sebagai bilangan bulat
                                  }
                              }
                          },
                          
                          grid: { borderColor: '#f1f1f1' }
                      };

                      // === Hapus chart lama sebelum render baru ===
                      chartContainer.innerHTML = '';
                      chart = new ApexCharts(chartContainer, chartOptions);
                      chart.render();
                      
                  })
                  .catch(error => console.error('Error fetching chart data:', error));


                  
          }

          // === Load awal (tanpa filter) ===
          loadChart();

          // === Update otomatis ketika tanggal berubah ===
          function handleDateChange() {
              const awal = inputAwal.value;
              const akhir = inputAkhir.value;

              if (awal && akhir) {
                  loadChart(awal, akhir);
              }
          }

          inputAwal.addEventListener('change', handleDateChange);
          inputAkhir.addEventListener('change', handleDateChange);

          
      });
      

      </script>

      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <script type="text/javascript">
        $(function(){
          var current = location.pathname;
          $('.nav-sidebar li a').each(function(){
            var $this = $(this);
              // if the current path is like this link, make it active
              if($this.attr('href').indexOf(current) !== -1){
                $this.addClass('active');
              }
          })
        })
      </script>

      <!--Filter smester-->
      <script>
        $(function () {
          $('#semesterRange').daterangepicker({
            ranges   : {
              'Semester 1 (Jan - Jun)' : [
                moment().startOf('year'),
                moment().month(5).endOf('month')
              ],
              'Semester 2 (Jul - Dec)' : [
                moment().month(6).startOf('month'),
                moment().endOf('year')
              ]
            },
            startDate: moment().startOf('year'),
            endDate  : moment().month(5).endOf('month'),
            locale: {
              format: 'YYYY-MM-DD'
            }
          }, function (start, end, label) {
            console.log("Filter:", start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
            // contoh redirect ke Laravel
            // window.location = '?start=' + start.format('YYYY-MM-DD') + '&end=' + end.format('YYYY-MM-DD');
          });
        });

      </script>

      <script>
          // Fungsi untuk pasang pesan validasi Bahasa Indonesia
          function setValidation(input) {
            input.addEventListener('invalid', function () {
              if (input.validity.valueMissing) {
                input.setCustomValidity('Kolom ini wajib diisi.');
              } else if (input.validity.typeMismatch) {
                input.setCustomValidity('Format data tidak valid.');
              } else {
                input.setCustomValidity('');
              }
            });

            input.addEventListener('input', function () {
              input.setCustomValidity('');
            });
          }

          // Pasang di form tambah
          document.querySelectorAll('#modalFormTambah input, #modalFormTambah select, #modalFormTambah textarea')
            .forEach(input => setValidation(input));

          // Pasang di form edit
          document.querySelectorAll('#modalFormEdit input, #modalFormEdit select, #modalFormEdit textarea')
            .forEach(input => setValidation(input));

          // Jika modal edit di-load dinamis (via AJAX atau muncul setelah klik edit):
          document.getElementById('modalFormEdit').addEventListener('shown.bs.modal', function() {
            document.querySelectorAll('#modalFormEdit input, #modalFormEdit select, #modalFormEdit textarea')
              .forEach(input => setValidation(input));
          });

          document.getElementById('modalFormTambah').addEventListener('shown.bs.modal', function() {
          document.querySelectorAll('#modalFormTambah input, #formTambah select, #modalFormTambah textarea')
              .forEach(input => setValidation(input));
          });
        </script>
        
       

      <script>
          const loader = document.getElementById("loader");

          // Sembunyikan loader saat halaman selesai dimuat
          window.addEventListener("load", () => {
              loader.style.display = "none";
          });

          // Tampilkan loader saat form disubmit
          document.querySelectorAll("form").forEach(form => {
              form.addEventListener("submit", () => {
                  loader.style.display = "flex";
              });
          });

          // Tampilkan loader saat berpindah halaman
          window.addEventListener("beforeunload", () => {
              loader.style.display = "flex";
          });

          // Perbaikan untuk tombol Back (BFCache)
          window.addEventListener("pageshow", (event) => {
              loader.style.display = "none";
              if (event.persisted) {
                  loader.style.display = "none";
              }
          });
      </script>

      <script>
        document.addEventListener('DOMContentLoaded', function () {
          // Aktifkan semua tooltip di halaman
          const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
          tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
          });
        });
      </script>

      
      <script>
function downloadJPG(){

    const dashboard = document.getElementById("exportDashboard");

    dashboard.classList.add("export-mode");

    html2canvas(dashboard,{
        scale:2,
        useCORS:true
    }).then(canvas=>{

        const link=document.createElement("a");
        link.download="dashboard.jpg";
        link.href=canvas.toDataURL("image/jpeg",1.0);
        link.click();

        dashboard.classList.remove("export-mode");

    });
}
</script>

<script>
  function downloadPDF(){

    const dashboard = document.getElementById("exportDashboard");

    // aktifkan mode export supaya icon tidak pakai gradient
    dashboard.classList.add("export-mode");

    html2canvas(dashboard,{
        scale:2,
        useCORS:true
    }).then(canvas=>{

        const imgData = canvas.toDataURL("image/png");

        const { jsPDF } = window.jspdf;

        // landscape supaya dashboard muat
        const pdf = new jsPDF('l','mm','a4');

        const imgWidth = 297; 
        const imgHeight = canvas.height * imgWidth / canvas.width;

        pdf.addImage(imgData,'PNG',0,0,imgWidth,imgHeight);

        pdf.save("dashboard-ticketing.pdf");

        // kembalikan style normal
        dashboard.classList.remove("export-mode");

    });

}
</script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>


      

  <!--end::Script-->

</body>
<!--end::Body-->

</html>