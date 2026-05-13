<style>
  .table-fixed {
    table-layout: fixed;
    width: 100%;
  }

  .detail-penanganan-content {
    max-height: 100%;
    overflow-y: auto;
    overflow-x: auto;
  }

  .detail-penanganan-content img,
  .detail-penanganan-content table {
    max-width: 100%;

    overflow-x: auto;
  }

  .col-label {
    width: 180px;
    white-space: nowrap;
  }
</style>
<!-- Modal Detail Penanganan -->
<div class="modal fade" id="modalDetailPenanganan" tabindex="-1" aria-labelledby="detailTicketLabel" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header th-merah">
        <h6 class="modal-title fw-bold text-light" id="detailTicketLabel">
          DETAIL PENANGANAN TICKET
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"
          style="filter: invert(1);"></button>
      </div>

      <div class="modal-body">
        <div class="table-wrapper">
          <table class="table table-borderless align-middle mb-0 table-fixed">
            <tbody>
              <tr>
                <td class="fw-semibold text-dark" style="width: 140px;">Tanggal Proses</td>
                <td style="width: 10px;">:</td>
                <td id="detailTanggal"></td>
              </tr>
              <tr>
                <td class="fw-semibold text-dark col-label">Penanganan</td>
                <td>:</td>
                <td>
                  <div class="detail-penanganan-content" id="detailPenanganan"></div>
                </td>
              </tr>
              <tr>
                <td class="fw-semibold text-dark">Status</td>
                <td>:</td>
                <td id="detailStatus"></td>
              </tr>
              <tr>
                <td class="fw-semibold text-dark">User Update</td>
                <td>:</td>
                <td id="detailUser"></td>
              </tr>
              <tr>
                <td class="fw-semibold text-dark">Dokumentasi</td>
                <td>:</td>
                <td id="detailDokumentasi"></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>