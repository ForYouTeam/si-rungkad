@extends('layout.Base')
@section('content')
<div class="col-lg-12">
    <div class="card">
      <div class="card-haeder">
        <h4 class="mt-5" style="float: left">Data Kunjungan Pasien</h4>
        <button style="float: right" 
        type="button" 
        class="btn btn-primary mt-5"
        id="createData">
          Tambah Data
        </button>
      </div>
      <div class="card-body">
        <table class="table table-striped table-hover" id="table-data">
            <thead>
                <tr>
                  <th>No</th>
                  <th>Profile</th>
                  <th>Registrasi</th>
                  <th>Tanggal Kunjungan</th>
                  <th>Waktu Kunjungan</th>
                  <th>Keterangan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  @php
                      $no = 1;
                  @endphp
                  @foreach ($data as $item)
                  <tr>
                      <td style="width: 10%">{{ $no++                    }}</td>
                      <td style="width: 10%">{{ $item->nama_profile      }}</td>
                      <td style="width: 10%">{{ $item->registrasi  }}</td>
                      <td style="width: 10%">{{ $item['tgl_kunjungan']   }}</td>
                      <td style="width: 10%">{{ $item['waktu_kunjungan'] }}</td>
                      <td style="width: 10%">{{ $item['keterangan']      }}</td>
                      <td style="width: 10%">
                          <button class="editItem btn btn-info btn-sm" 
                                  data-id="{{$item->id}}">
                                  Edit
                          </button>
                          <button class="btn btn-danger btn-sm" 
                                  data-id="{{$item->id}}"
                                  id="btn-hapus">
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
          <h5 class="modal-title" id="exampleModalLabel">Data Kunjungan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="formData" onsubmit="return false">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" name="id" id="dataId">
              <div class="col-md-12">
                <label class="form-label">Nama</label>
                <select name="profile_id" id="profile_id" class="form-control" required>
                  <option value="" selected disabled>--pilih--</option>
                  @foreach ($profileid as $d)
                      <option value="{{$d->id}}">{{$d->nama}}</option>
                  @endforeach
                </select>
                <span class="text-danger error-msg small" id="nama-alert"></span>
              </div>
              <div class="col-md-12">
                <label class="form-label">No Registrasi</label>
                <select name="registation_id" id="registation_id" class="form-control" required>
                  <option value="" selected disabled>--pilih--</option>
                  @foreach ($registationid as $d)
                      <option value="{{$d->id}}">{{$d->no_registrasi}}</option>
                  @endforeach
                </select>
                <span class="text-danger error-msg small" id="no_registrasi-alert"></span>
              </div>
              <div class="col-md-12">
                <label class="form-label">Tanggal Kunjungan</label>
                <input type="date" class="form-control" name="tgl_kunjungan" id="tgl_kunjungan" placeholder="Tanggal Kunjungan" required>
                <span class="text-danger error-msg small" id="tgl_kunjungan-alert"></span>
              </div>
              <div class="col-md-12">
                <label class="form-label">Waktu Kunjungan</label>
                <input type="time" class="form-control" name="waktu_kunjungan" id="waktu_kunjungan" placeholder="Waktu Kunjungan" required>
                <span class="text-danger error-msg small" id="waktu_kunjungan-alert"></span>
              </div>
              <div class="col-md-12">
                <label class="form-label">Keterangan</label>
                <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" required>
                <span class="text-danger error-msg small" id="keterangan-alert"></span>
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
        

        $('#createData').click(function () {
            $('.modal-title').html   ("Formulir Tambah Data");
            $('#btn-simpan' ).val    ("create-Item"         );
            $('#id'         ).val    (''                    );
            $('#formData'   ).trigger("reset"               );
            $('#modal-data' ).modal  ('show'                );
            $('#nama-alert' ).html   (''                    );
        });

        $('body').on('click', '.editItem', function () {
          console.log('ini console');
            var _id = $(this).data('id');
            $.get(`${baseUrl}/api/v1/visithistory/` + _id, function (res) {
                $('.modal-title' ).html ("Formulir Edit Data" );
                $('#btn-simpan'  ).val  ("edit-user"          );
                $('#modal-data'  ).modal('show'               );
                $('#nama_profile').val  (res.data.nama_profile);
                $('#registrasi').val  (res.data.registrasi);
                $('#tgl_kunjungan').val  (res.data.tgl_kunjungan);
                $('#waktu_kunjungan').val  (res.data.waktu_kunjungan);
                $('#keterangan').val  (res.data.keterangan);
                $('#dataId'      ).val  (res.data.id          );
            })
        });

        $('#btn-simpan').click(function (e) {
            e.preventDefault();
            let submitButton = $(this);
            submitButton.html('Simpan');

            if (!submitButton.prop('disabled')) {
                $.ajax({
                    data    : $('#formData').serialize()  ,
                    url     : `${baseUrl}/api/v1/visithistory`,
                    type    : "POST"                      ,
                    dataType: 'json'                      ,
                    success: function(result) {
                        Swal.fire({
                            title            : 'Success'               ,
                            text             : 'Data Berhasil diproses',
                            icon             : 'success'               ,
                            cancelButtonColor: '#d33'                  ,
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
                                $('#nama_profile-alert').html(errorRes.data.nama_profile);
                                $('#registrasi-alert').html(errorRes.data.registrasi);
                                $('#tgl_kunjungan-alert').html(errorRes.data.tgl_kunjungan);
                                $('#waktu_kunjungan-alert').html(errorRes.data.waktu_kunjungan);
                                $('#keterangan-alert').html(errorRes.data.keterangan);
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
            let url = `${baseUrl}/api/v1/visithistory/` + _id;
            Swal.fire({
                title             : 'Anda Yakin?',
                text              : "Data ini mungkin terhubung ke tabel yang lain!",
                icon              : 'warning',
                showCancelButton  : true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor : '#d33',
                cancelButtonText  : 'Batal',
                confirmButtonText : 'Hapus'
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'delete',
                        success: function(result) {
                            let data = result.data;
                            Swal.fire({
                                title            : 'Success'               ,
                                text             : 'Data Berhasil Dihapus.',
                                icon             : 'success'               ,
                                cancelButtonColor: '#d33'                  ,
                                confirmButtonText: 'Oke'
                            }).then((result) => {
                                location.reload();
                            });
                        },
                        error: function(result) {
                            let msg
                            if (result.responseJSON) {
                                let data = result.responseJSON
                                message  = data.message
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
