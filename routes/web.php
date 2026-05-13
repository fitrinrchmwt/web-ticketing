<?php

use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DeskripsiController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\BroadcastController;
use App\Http\Controllers\LoginController;

//login
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::get('/login', [LoginController::class, 'index']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//lupa password & reset password
Route::get('/lupapassword', [LoginController::class, 'LupaPassword'])->name('password.request');
Route::post('/lupapassword', [LoginController::class, 'kirimLinkReset'])->name('password.email');
Route::post('/lupapassword/kirim', [LoginController::class, 'kirimLinkReset'])->name('lupapassword.kirim');
Route::get('/reset_password/{token}', [LoginController::class, 'formResetPassword'])->name('password.reset');
Route::post('/reset_password', [LoginController::class, 'resetPassword'])->name('password.update');

// Departemen
Route::middleware(['permission:data_master'])->group(function () {
    Route::get('/keloladepartemen', [DepartemenController::class, 'kelola_departemen']);
    Route::post('/keloladepartemen/store', [DepartemenController::class, 'store'])->name('departemen.store');
    Route::post('/keloladepartemen/update', [DepartemenController::class, 'update'])->name('departemen.update');
    Route::delete('/hapusdepartemen/{id_departemen}', [DepartemenController::class, 'delete'])->name('departemen.delete');

    // Role
    Route::get('/kelolarole', [RoleController::class, 'kelola_role']);
    Route::post('/kelolarole/store', [RoleController::class, 'store'])->name('role.store');
    Route::post('/kelolarole/update', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/hapusrole/{id_role}', [RoleController::class, 'delete'])->name('delete.role');
    Route::get('/detailrole/{id_role}', [RoleController::class, 'detail'])->name('role.detail');

    // Pengguna
    Route::get('/kelolapengguna', [PenggunaController::class, 'kelola_pengguna']);
    Route::post('/kelolapengguna/create', [PenggunaController::class, 'create'])->name('pengguna.create');
    Route::post('/kelolapengguna/update', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/hapuspengguna/{id_pengguna}', [PenggunaController::class, 'delete'])->name('pengguna.delete');

    //template
    Route::get('/kelolatemplate', [TemplateController::class, 'kelola_template']);
    Route::post('/kelolatemplate/store', [TemplateController::class, 'store'])->name('template.store');
    Route::post('/kelolatemplate/update', [TemplateController::class, 'update'])->name('template.update');
    Route::delete('/hapustemplate/{id_template}', [TemplateController::class, 'delete'])->name('template.delete');

    //layanan
    Route::get('/kelolalayanan', [LayananController::class, 'kelola_layanan']);
    Route::post('/kelolalayanan/store', [LayananController::class, 'store'])->name('layanan.store');
    Route::post('/kelolalayanan/update', [LayananController::class, 'update'])->name('layanan.update');
    Route::delete('/hapuslayanan/{id_layanan}', [LayananController::class, 'delete'])->name('layanan.delete');

    //deskripsi
    Route::get('/kelola_template_deskripsi', [DeskripsiController::class, 'kelola_template_deskripsi']);
    Route::post('/kelola_template_deskripsi/store', [DeskripsiController::class, 'store'])->name('deskripsi.store');
    Route::post('/kelola_template_deskripsi/update', [DeskripsiController::class, 'update'])->name('deskripsi.update');
    Route::delete('/hapusdeskripsi/{id_deskripsi}', [DeskripsiController::class, 'delete'])->name('deskripsi.delete');
    Route::post('/upload-summernote', [DeskripsiController::class, 'uploadSummernote'])
        ->name('summernote.upload');

    //kategori
    Route::get('/kelolakategori', [KategoriController::class, 'kelola_kategori']);
    Route::post('/kelolakategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::post('/kelolakategori/update', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/hapuskategori/{id_kategori}', [KategoriController::class, 'delete'])->name('kategori.delete');

    //status
    Route::get('/kelolastatus', [StatusController::class, 'kelola_status'])->name('status.kelola');
    Route::post('/kelolastatus/store', [StatusController::class, 'store'])->name('status.store');
    Route::post('/kelolastatus/update', [StatusController::class, 'update'])->name('status.update');
    Route::delete('/kelolastatus/delete/{id}', [StatusController::class, 'delete'])->name('status.delete');


    //subject
    Route::get('/kelolasubject', [SubjectController::class, 'kelola_subject'])->name('subject.kelola');
    Route::post('/kelolasubject/store', [SubjectController::class, 'store'])->name('subject.store');
    Route::post('/kelolasubject/update', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('/kelolasubject/delete/{id}', [SubjectController::class, 'delete'])->name('subject.delete');

});

// Home
Route::get('/home', [HomeController::class, 'dashboard'])->middleware('permission:dashboard');

// report
Route::get('/report', [ReportController::class, 'index'])->name('report')->middleware('permission:report');
Route::get('/report/filter', [ReportController::class, 'filter'])->name('report.filter');


//Data Pelanggan
Route::middleware(['permission:data_pelanggan'])->group(function () {
    Route::get('/datapelanggan', [PelangganController::class, 'data_pelanggan'])->name('data.pelanggan');
    Route::get('/datapelanggan/sync', [PelangganController::class, 'sync'])->name('datapelanggan.sync');
    Route::get('/datapelanggan/detail/{custNumber}', [PelangganController::class, 'show'])->name('datapelanggan.detail');
});

//Ticket Routes
Route::middleware(['permission:ticket'])->group(function () {
    Route::get('/dashboard-ticket', [TicketController::class, 'dashboard'])->name('ticket.dashboard');
    Route::get('/ticket/create', [TicketController::class, 'create'])->name('ticket.create');
    Route::post('/ticket/store', [TicketController::class, 'store'])->name('ticket.store');
    Route::get('/ticket/update/{id_ticket}', [TicketController::class, 'update'])->name('ticket.update');

    Route::post('/ticket/update', [TicketController::class, 'store_update'])->name('ticket.store_update');

    Route::get('/history-ticket/{id_ticket}', [TicketController::class, 'history'])->name('ticket.history');
    Route::get('/ticket/detail/{id_ticket}', [TicketController::class, 'detail'])->name('ticket.detail');

    Route::post('/ticket/bookmark/{id_ticket}', [TicketController::class, 'bookmark'])->name('ticket.bookmark');


    Route::delete('/ticket/destroy/{id_ticket}', [TicketController::class, 'destroy'])->name('ticket.destroy');

    Route::get('/ticket/unfinished', [TicketController::class, 'get_unfinished'])->name('ticket.unfinished');

    Route::post('/ticket/get-ticket-ref', [TicketController::class, 'get_ticket_ref'])->name('ticket.ticketrefs');

    // History jadwal
    Route::post('/ticket/jadwal', [TicketController::class, 'create_jadwal'])->name('ticket.jadwal');
    Route::post('/ticket/jadwal/edit', [TicketController::class, 'update_jadwal'])->name('ticket.edit_jadwal');

    // History penanganan
    Route::post('/ticket/penanganan', [TicketController::class, 'create_penanganan'])->name('ticket.penanganan');
    Route::post('/ticket/penanganan/edit', [TicketController::class, 'update_penanganan'])->name('ticket.edit_penanganan');

    //upload foto deskripsi penanganan
    Route::post('/upload/summernote', [TicketController::class, 'uploadSummernote']);


    //filter ticket ajax
    Route::get('/ticket/list', [TicketController::class, 'list_ticket'])
        ->name('ticket.list');
});


//broadcast
Route::middleware(['permission:broadcast'])->group(function () {
    Route::get('/broadcast', [BroadcastController::class, 'broadcast']);
    Route::post('/broadcast/store', [BroadcastController::class, 'store'])->name('broadcast.store');
    Route::get('/broadcast/datapelanggan', [BroadcastController::class, 'getDataPelanggan'])->name('broadcast.data');
});




Route::get('/ticket/customers', [TicketController::class, 'get_customers'])->name('ticket.customers');

Route::get('/home/chart-data', [HomeController::class, 'getChartData'])->name('chart.data');



// Route::get('/test', [LoginController::class, 'test']);
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    return 'Storage link berhasil dibuat';
});
