@extends('layout.Base')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 d-flex">
                    <h4 class="col-sm-8">Data Jadwal</h4>
                    <div class="col-sm-4 d-flex flex-row-reverse">
                        <button type="button" class="btn btn-primary" id="createData">
                            Tambah Data
                        </button>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <select name="jadwal" id="jadwal" class="form-select">
                        <option value="x" selected disabled>-- Pilih hari --</option>
                        @foreach ($data as $item)
                            <option value="{{ $item->id }}">{{ $item->hari }}</option>
                        @endforeach
                    </select>
                </div>
                <table class="table table-striped table-hover" id="table-data">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Hari</th>
                            <th scope="col">Poly</th>
                            <th scope="col">Jam Masuk</th>
                            <th scope="col">Jam Keluar</th>
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
                                <td style="width: 10%">{{ $item->hari }}</td>
                                <td style="width: 10%">{{ $item->nama_poly }}</td>
                                <td style="width: 10%">{{ $item->start_time }}</td>
                                <td style="width: 10%">{{ $item->end_time }}</td>
                                <td style="width: 10%">
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
                    <h5 class="modal-title" id="exampleModalLabel">Data Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formData" onsubmit="return false">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="schedule_id" id="schedule_id">
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Poly</label>
                                <select name="poly_id" id="poly_id" class="form-select">
                                    <option value="">Input disini</option>
                                    @foreach ($poly as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-msg small" id="nama-alert"></span>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Jam Mulai</label>
                                <input type="time" name="start_time" id="start_time" class="form-control">
                                <span class="text-danger error-msg small" id="nama-alert"></span>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Jam Selesai</label>
                                <input type="time" name="end_time" id="end_time" class="form-control">
                                <span class="text-danger error-msg small" id="nama-alert"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
            var jdl = $('#jadwal').val()
            if (jdl == null) {
                Swal.fire({
                    title: 'Gagal',
                    text: 'Silahkan pilih hari dulu',
                    icon: 'error',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oke'
                })
            } else {
                $('.modal-title').html("Formulir Tambah Data");
                $('#btn-simpan').val("create-Item");
                $('#id').val('');
                $('#formData').trigger("reset");
                $('#modal-data').modal('show');
                $('#hari-alert').html('');
            }
        });

        $('#jadwal').change(function() {
            var valSchedule = $(this).val()
            $('#schedule_id').val(valSchedule);
        });

        $('#btn-simpan').click(function(e) {
            e.preventDefault();
            let submitButton = $(this);
            submitButton.html('Simpan');

            if (!submitButton.prop('disabled')) {
                $.ajax({
                    data: $('#formData').serialize(),
                    url: `${baseUrl}/api/v1/schedule`,
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
                                $('#nama_poharily-alert').html(errorRes.data.hari);
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
            let url = `${baseUrl}/api/v1/schedule/` + _id;
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
