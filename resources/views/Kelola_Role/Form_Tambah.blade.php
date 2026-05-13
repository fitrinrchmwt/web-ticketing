<div class="modal fade" id="modalFormTambahRole" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('role.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data Role</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id_role" value="{{ $kodeOtomatis }}" readonly>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Role</label>
                        <input name="nama_role" id="nama_role" class="form-control" type="text"
                            placeholder="Masukkan nama role" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Akses</label>
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-6">
                                    <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                        id="perm_{{ $permission->id_permission }}" value="{{ $permission->id_permission }}"
                                        @if(isset($rolePermissions) && in_array($permission->id_permission, $rolePermissions)) checked >
                                        @endif
                                    <label class="form-check-label" for="perm_{{ $permission->id_permission }}">
                                        {{ $permission->alias }}
                                    </label>
                                </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>