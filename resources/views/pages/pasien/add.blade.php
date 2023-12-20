@extends('layout.Base')
@section('content')
    <div>
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12 d-flex">
                        <h4 class="col-sm-10">Tambah/Edit Data Pasien</h4>
                    </div>
                    <hr>
                    <form id="formData" onsubmit="return false">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="id" id="dataId">
                                <div class="mb-2">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="nama"
                                        placeholder="Input disini" required>
                                    <span class="text-danger error-msg small" id="nama-alert"></span>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">NIK</label>
                                    <input type="text" class="form-control" name="nik" id="nik"
                                        placeholder="Input disini" required>
                                    <span class="text-danger error-msg small" id="no_hp-alert"></span>
                                </div>
                                <div class="mb-2">
                                    <div class="col-md-12">
                                        <label class="form-label">Status Nikah</label>
                                        <select name="status_nikah" id="status_nikah" class="form-select">
                                            <option value="0">Belum</option>
                                            <option value="1">Sudah</option>
                                        </select>
                                        <span class="text-danger error-msg small" id="email-alert"></span>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamat" id="alamat" cols="30" rows="6" class="form-control" placeholder="Input disini"></textarea>
                                    <span class="text-danger error-msg small" id="alamat-alert"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select name="jk" id="jk" class="form-select">
                                        <option value="" selected disabled>Pilih</option>
                                        <option value="pria">Laki-Laki</option>
                                        <option value="wanita">Perempuan</option>
                                    </select>
                                    <span class="text-danger error-msg small" id="pekerjaan-alert"></span>
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
                                <div class="mb-2">
                                    <label class="form-label">Pekerjaan</label>
                                    <input type="text" class="form-control" name="pekerjaan" id="pekerjaan"
                                        placeholder="Input dsini" required>
                                    <span class="text-danger error-msg small" id="pekerjaan-alert"></span>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Kewarganegaraan</label>
                                    <input type="text" class="form-control" name="kewarganegaraan" id="kewarganegaraan"
                                        placeholder="Input disini" required>
                                    <span class="text-danger error-msg small" id="status-alert"></span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-row-reverse mt-4" style="gap: 10px">
                            <button class="btn btn-outline-primary" id="btn-simpan">Simpan</button>
                            <button class="btn btn-outline-danger" id="cancel">Batal</button>
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
        let cancelBtn = $('#cancel')

        $(document).ready(function() {
            baseUrl = "{{ config('app.url') }}"

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            editData();
        });

        $(cancelBtn).click(function () { 
            window.location.href = "{{ route('profile') }}";
            
        });

        function editData() {
            var currentUrl = window.location.href;
            var match = currentUrl.match(/\/profile\/add\/(\d+)/);

            if (match && match[1]) {
                var _id = match[1];

                $.get(`${baseUrl}/api/v1/profile/` + _id, function(res) {
                    $('#nama').val(res.data.nama);
                    $('#alamat').val(res.data.alamat);
                    $('#nik').val(res.data.nik);
                    $('#jk').val(res.data.jk);
                    $('#email').val(res.data.email);
                    $('#pekerjaan').val(res.data.pekerjaan);
                    $('#status_nikah').val(res.data.status_nikah);
                    $('#agama').val(res.data.agama);
                    $('#kewarganegaraan').val(res.data.kewarganegaraan);
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
                    url: `${baseUrl}/api/v1/profile`,
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
                            window.location.href = "{{ route('profile') }}";
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
                                $('#nik-alert').html(errorRes.data.nik);
                                $('#status_nikah-alert').html(errorRes.data.status_nikah);
                                $('#kewarganegaraan-alert').html(errorRes.data.kewarganegaraan);
                                $('#pekerjaan-alert').html(errorRes.data.pekerjaan);
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
