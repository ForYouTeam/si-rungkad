@extends('layout.Base')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 d-flex mb-4">
                    <h4 class="col-sm-10">Data Registrasi</h4>
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
                            <th scope="col">No Registrasi</th>
                            <th scope="col">No Rekam Medis</th>
                            <th scope="col">Nama Poly</th>
                            <th scope="col">Tanggal Registrasi</th>
                            <th scope="col">Lampiran</th>
                            <th scope="col">QR Code</th>
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
                                <td style="width: 10%">{{ $item['no_registrasi'] }}</td>
                                <td style="width: 10%">{{ $item['rekammedis'] }}</td>
                                <td style="width: 10%">{{ $item['nama_poly'] }}</td>
                                <td style="width: 10%">{{ $item['tgl_registrasi'] }}</td>
                                <td style="width: 10%">{{ $item->ktp }} - {{ $item->kb }}</td>
                                <td style="width: 10%">{{ $item['qr_code'] }}</td>
                                <td style="width: 10%">
                                    <button class="editItem btn btn-info btn-sm" data-id="{{ $item->id }}">
                                        Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-id="{{ $item->id }}" id="btn-hapus">
                                        Hapus
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
                    <h5 class="modal-title" id="exampleModalLabel">Data Registrasi Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formData" onsubmit="return false">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id" id="dataId">
                            <div class="col-md-12">
                                <label class="form-label">No Registrasi</label>
                                <input type="text" class="form-control" name="no_registrasi" id="no_registrasi"
                                    placeholder="No Registrasi" required>
                                <span class="text-danger error-msg small" id="no_registrasi-alert"></span>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">No Rekam Medis</label>
                                <input type="text" class="form-control" name="no_rm" id="no_rm"
                                    placeholder="No Rekam Medis" required>
                                <span class="text-danger error-msg small" id="rekam_medis-alert"></span>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Nama Poly</label>
                                <select name="nama_poly" id="nama_poly" class="form-control" required>
                                    <option value="" selected disabled>--pilih--</option>
                                    @foreach ($polyid as $d)
                                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-msg small" id="nama-alert"></span>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Tanggal Registrasi</label>
                                <input type="date" class="form-control" name="tgl_registrasi" id="tgl_registrasi"
                                    placeholder="Tanggal Registrasi" required>
                                <span class="text-danger error-msg small" id="tgl_registrasi-alert"></span>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Lampiran</label>
                                <select name="attachment_id" id="attachment_id" class="form-control" required>
                                    <option value="" selected disabled>--pilih--</option>
                                    @foreach ($lampiran as $d)
                                        <option value="{{ $d->id }}">{{ $d->foto_ktp }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-msg small" id="ktp-kartu_berobat-alert"></span>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">QR Code</label>
                                <input type="text" class="form-control" name="qr_code" id="qr_code"
                                    placeholder="QR code" required>
                                <span class="text-danger error-msg small" id="qr_code-alert"></span>
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
            $('.modal-title').html("Formulir Tambah Data");
            $('#btn-simpan').val("create-Item");
            $('#id').val('');
            $('#formData').trigger("reset");
            $('#modal-data').modal('show');
            $('#nama-alert').html('');
        });

        $('body').on('click', '.editItem', function() {
            console.log('ini console');
            var _id = $(this).data('id');
            $.get(`${baseUrl}/api/v1/registation/` + _id, function(res) {
                $('.modal-title').html("Formulir Edit Data");
                $('#btn-simpan').val("edit-user");
                $('#modal-data').modal('show');
                $('#no_registrasi').val(res.data.no_registrasi);
                $('#rekammedis').val(res.data.rekammedis);
                $('#nama_poly').val(res.data.nama_poly);
                $('#tgl_registrasi').val(res.data.tgl_registrasi);
                $('#ktp').val(res.data.ktp);
                $('#qr_code').val(res.data.qr_code);
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
                    url: `${baseUrl}/api/v1/registation`,
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
                                $('#no_registrasi-alert').html(errorRes.data.no_registrasi);
                                $('#rekammedis-alert').html(errorRes.data.rekammedis);
                                $('#nama_poly-alert').html(errorRes.data.nama_poly);
                                $('#tgl_registarsi-alert').html(errorRes.data.tgl_registarsi);
                                $('#ktp-alert').html(errorRes.data.ktp);
                                $('#qr_code-alert').html(errorRes.data.qr_code);
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
            let url = `${baseUrl}/api/v1/registation/` + _id;
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
