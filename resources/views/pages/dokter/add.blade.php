@extends('layout.Base')
@section('content')
    <div>
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12 d-flex">
                        <h4 class="col-sm-10">Tambah/Edit Data Dokter</h4>
                    </div>
                    <hr>
                    <form id="formData" onsubmit="return false">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="user_id" id="user_id" value="1">
                                <input type="hidden" name="id" id="dataId">
                                <div class="mb-2">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="nama"
                                        placeholder="Nama" required>
                                    <span class="text-danger error-msg small" id="nama-alert"></span>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">No Handphone</label>
                                    <input type="number" class="form-control" name="no_hp" id="no_hp"
                                        placeholder="No Handphone" required>
                                    <span class="text-danger error-msg small" id="no_hp-alert"></span>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select name="jk" id="jk" class="form-control">
                                        <option value="" selected disabled>--pilih--</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <span class="text-danger error-msg small" id="jk-alert"></span>
                                </div>
                                <div class="mb-2">
                                    <div class="col-md-12">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="Email" required>
                                        <span class="text-danger error-msg small" id="email-alert"></span>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamat" id="alamat" cols="30" rows="6" class="form-control"></textarea>
                                    <span class="text-danger error-msg small" id="alamat-alert"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Pekerjaan</label>
                                    <input type="text" class="form-control" name="pekerjaan" id="pekerjaan"
                                        placeholder="Pekerjaan" required>
                                    <span class="text-danger error-msg small" id="pekerjaan-alert"></span>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Status</label>
                                    <input type="text" class="form-control" name="status" id="status"
                                        placeholder="Status" required>
                                    <span class="text-danger error-msg small" id="status-alert"></span>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir"
                                        placeholder="Tanggal Lahir" required>
                                    <span class="text-danger error-msg small" id="tgl_lahir-alert"></span>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Agama</label>
                                    <select name="agama" id="agama" class="form-select">
                                        <option value="" selected disabled>Pilih</option>
                                        <option value="islam">Islam</option>
                                        <option value="kristen">Kristen</option>
                                        <option value="katolik">Katolik</option>
                                        <option value="hindu">Hindu</option>
                                        <option value="budha">Budha</option>
                                        <option value="khonghucu">Khonghucu</option>
                                    </select>
                                    <span class="text-danger error-msg small" id="agama-alert"></span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-row-reverse mt-4" style="gap: 10px">
                            <button class="btn btn-outline-primary" id="btn-simpan">Simpan</button>
                            <button class="btn btn-outline-danger">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let baseUrl

        $(document).ready(function() {
            baseUrl = "{{ config('app.url') }}"

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            editData();
        });

        function editData() {
            var currentUrl = window.location.href;
            var match = currentUrl.match(/\/dokter\/add\/(\d+)/);

            if (match && match[1]) {
                var _id = match[1];

                $.get(`${baseUrl}/api/v1/doctorprofile/` + _id, function(res) {
                    $('#nama').val(res.data.nama);
                    $('#alamat').val(res.data.alamat);
                    $('#no_hp').val(res.data.no_hp);
                    $('#jk').val(res.data.jk);
                    $('#email').val(res.data.email);
                    $('#pekerjaan').val(res.data.pekerjaan);
                    $('#status').val(res.data.status);
                    $('#tgl_lahir').val(res.data.tgl_lahir);
                    $('#agama').val(res.data.agama);
                    $('#dataId').val(res.data.id);
                })
            }
        }

        $('#btn-simpan').click(function(e) {
            e.preventDefault();
            let submitButton = $(this);
            submitButton.html('Simpan');

            if (!submitButton.prop('disabled')) {
                $.ajax({
                    data: $('#formData').serialize(),
                    url: `${baseUrl}/api/v1/doctorprofile`,
                    type: "POST",
                    dataType: 'json',
                    success: function(result) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Data Berhasil diproses',
                            icon: 'success',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Oke'
                        }).then((result) => {
                            window.location.href = "{{ route('dokter') }}";
                        });
                    },
                    error: function(result) {
                        submitButton.prop('disabled', false);
                        if (result.status = 422) {
                            let data = result.responseJSON
                            let errorRes = data.errors;
                            if (errorRes.length >= 1) {
                                $('#nama-alert').html(errorRes.data.nama);
                                $('#alamat-alert').html(errorRes.data.alamat);
                                $('#no_hp-alert').html(errorRes.data.no_hp);
                                $('#jk-alert').html(errorRes.data.jk);
                                $('#email-alert').html(errorRes.data.email);
                                $('#pekerjaan-alert').html(errorRes.data.pekerjaan);
                                $('#status-alert').html(errorRes.data.status);
                                $('#tgl_lahir-alert').html(errorRes.data.tgl_lahir);
                                $('#agama-alert').html(errorRes.data.agama);
                            }
                        } else {
                            let msg = 'Sedang pemeliharaan server'
                            iziToast.error(msg)
                        }
                    }
                });
            }
        });
    </script>
@endsection
