<div class="modal fade" id="modalFormEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('role.update') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data Role Pengguna</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id_role" id="edit_id_role">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Role</label>
                        <input name="nama_role" id="edit_nama_role" class="form-control" type="text" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Akses</label>
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input edit-permission" type="checkbox" name="permissions[]"
                                            value="{{ $permission->id_permission }}"
                                            id="edit_perm_{{ $permission->id_permission }}">
                                        <label class="form-check-label" for="edit_perm_{{ $permission->id_permission }}">
                                            {{ $permission->alias }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.edit-role-btn');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                // Isi data dasar role
                document.getElementById('edit_id_role').value = this.dataset.id_role;
                document.getElementById('edit_nama_role').value = this.dataset.nama_role;

                // Reset semua checkbox permission dulu
                document.querySelectorAll('.edit-permission').forEach(cb => cb.checked = false);

                // Ambil data permission milik role dari atribut data-permission (array string)
                const rolePermissions = JSON.parse(this.dataset.permissions || '[]');

                // Centang permission yang dimiliki role
                rolePermissions.forEach(idPerm => {
                    const checkbox = document.getElementById('edit_perm_' + idPerm);
                    if (checkbox) checkbox.checked = true;
                });
            });
        });
    });
</script>