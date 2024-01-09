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
                            <th scope="col">Nama</th>
                            <th scope="col">Aksi</th>
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
                                <td style="width: 10%">{{ $item['no_rm'] }}</td>
                                <td style="width: 10%">{{ $item['nama'] }}</td>
                                <td style="width: 10%">
                                    <button class="editItem btn btn-info btn-sm" data-id="{{ $item['id'] }}">
                                        Edit
                                    </button>
                                    <a href="{{route('regis-detail', $item['id'])}}" class="btn btn-warning btn-sm" data-id="{{ $item['id'] }}">
                                        History
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Nama Pasien</label>
                                <select name="profile_id" id="profile_id" class="form-control" required>
                                    <option value="" selected disabled>--pilih--</option>
                                    @foreach ($profile as $d)
                                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-msg small" id="nama-alert"></span>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label">No Rekam Medis</label>
                                <input type="text" class="form-control" name="no_rm" id="no_rm" readonly>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tgl" id="tgl">
                                <span class="text-danger error-msg small" id="no_registrasi-alert"></span>
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
        let profile = $('#profile_id')

        $(document).ready(function() {
            baseUrl = "{{ config('app.url') }}"

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#table-data').DataTable();
        });

        $(profile).change(function(e) {
            var profId = $(this).val();
            $.get(`${baseUrl}/api/v1/profile/` + profId, function(res) {
                var rkm = res.data.no_rm;
                $('#no_rm').val(rkm);
            })

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
            var _id = $(this).data('id');
            $.get(`${baseUrl}/api/v1/registation/` + _id, function(res) {
                $('.modal-title').html("Formulir Edit Data");
                $('#btn-simpan').val("edit-user");
                $('#modal-data').modal('show');
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
                                $('#profile_id-alert').html(errorRes.data.profile_id);
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
