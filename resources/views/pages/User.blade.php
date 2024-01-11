@extends('layout.Base')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 d-flex mb-4">
                    <h4 class="col-sm-10">Data Akun</h4>
                    <div class="col-sm-2 d-flex flex-row-reverse">
                        <button type="button" class="btn btn-primary" id="createData">
                            Tambah Data
                        </button>
                    </div>
                </div>
                <table class="table table-striped table-hover" id="table-data">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $item)
                            <tr>
                                <td style="width: 10%">{{ $no++ }}</td>
                                <td style="width: 10%">{{ $item['nama'] }}</td>
                                <td style="width: 10%">{{ $item['email'] }}</td>
                                <td style="width: 10%">{{ $item['scope'] }}</td>
                                <td style="width: 10%">
                                    <button class="editItem btn btn-info btn-sm" data-id="{{ $item->id }}">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-id="{{ $item->id }}" id="btn-hapus">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->
    <!-- Modal -->

    <div class="modal fade" id="modal-data" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formData" onsubmit="return false">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id" id="dataId">
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama"
                                    required>
                                <span class="text-danger error-msg small" id="nama-alert"></span>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Input disini" required>
                                <span class="text-danger error-msg small" id="username-alert"></span>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Password</label>
                                <input type="text" class="form-control" name="password" id="password"
                                    placeholder="Password" required>
                                <span class="text-danger error-msg small" id="password-alert"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan</button>
                        </div>
                </form>
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
            $('#table-data').DataTable();
        });


        $('#createData').click(function() {
            $('.modal-title').html("Formulir Tambah Data");
            $('#btn-simpan').val("create-Item");
            $('#password').attr("placeholder", "Masukan Password");
            $('#id').val('');
            $('#formData').trigger("reset");
            $('#modal-data').modal('show');
            $('#nama-alert').html('');
        });

        $('body').on('click', '.editItem', function() {
            console.log('ini console');
            var _id = $(this).data('id');
            $.get(`${baseUrl}/api/v1/user/` + _id, function(res) {
                $('.modal-title').html("Formulir Edit Data");
                $('#btn-simpan').val("edit-user");
                $('#password').attr("placeholder", "Masukan Password Baru");
                $('#modal-data').modal('show');
                $('#nama').val(res.data.nama);
                $('#email').val(res.data.email);
                $('#dataId').val(res.data.id);
            })
        });

        $('#btn-simpan').click(function(e) {
            e.preventDefault();
            let submitButton = $(this);
            submitButton.html('Simpan');

            if (!submitButton.prop('disabled')) {
                $.ajax({
                    data: $('#formData').serialize(),
                    url: `${baseUrl}/api/v1/user`,
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
                            location.reload();
                        });
                        $('#modal-data').modal('hide');
                    },
                    error: function(result) {
                        submitButton.prop('disabled', false);
                        if (result.status = 422) {
                            let data = result.responseJSON
                            let errorRes = data.errors;
                            if (errorRes.length >= 1) {
                                $('#nama-alert').html(errorRes.data.nama);
                                $('#username-alert').html(errorRes.data.username);
                                $('#scope-alert').html(errorRes.data.scope);
                            }
                        } else {
                            let msg = 'Sedang pemeliharaan server'
                            iziToast.error(msg)
                        }
                    }
                });
            }
        });

        $(document).on('click', '#btn-hapus', function() {
            let _id = $(this).data('id');
            let url = `${baseUrl}/api/v1/user/` + _id;
            Swal.fire({
                title: 'Anda Yakin?',
                text: "Data ini mungkin terhubung ke tabel yang lain!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Hapus'
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'delete',
                        success: function(result) {
                            let data = result.data;
                            Swal.fire({
                                title: 'Success',
                                text: 'Data Berhasil Dihapus.',
                                icon: 'success',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Oke'
                            }).then((result) => {
                                location.reload();
                            });
                        },
                        error: function(result) {
                            let msg
                            if (result.responseJSON) {
                                let data = result.responseJSON
                                message = data.message
                            } else {
                                msg = 'Sedang pemeliharaan server'
                            }
                            iziToast.error(msg)
                        }
                    });
                }
            })
        });
    </script>
@endsection
