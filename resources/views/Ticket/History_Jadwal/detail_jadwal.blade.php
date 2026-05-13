
<!-- Modal Detail Penanganan -->
<div class="modal fade" id="modalDetailJadwal" tabindex="-1" aria-labelledby="detailTicketLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header th-merah">
        <h6 class="modal-title fw-bold text-light" id="detailTicketLabel">
          DETAIL JADWAL TICKET
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"
        style="filter: invert(1);"></button>
        </div>

      <div class="modal-body">
        <table class="table table-borderless align-middle mb-0">
          <tbody>
            <tr>
              <td class="fw-semibold text-dark" style="width: 180px;">Tanggal Jadwal</td>
              <td style="width: 10px;">:</td>
              <td id="detailjadwal"></td>
            </tr>
            <tr>
              <td class="fw-semibold text-dark">PIC Teknisi</td>
              <td>:</td>
              <td id="detailpengguna"></td>
            </tr>
            <tr>
              <td class="fw-semibold text-dark">Catatan</td>
              <td>:</td>
              <td id="detailcatatan"></td>
            </tr>
            <tr>
              <td class="fw-semibold text-dark">User Update</td>
              <td>:</td>
              <td id="detailupdated_by"></td>
            </tr>
            
          </tbody>
        </table>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>