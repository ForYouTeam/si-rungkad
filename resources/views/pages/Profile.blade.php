@extends('layout.Base')
@section('content')
<div class="col-lg-12">
  <div class="card">
    <div class="card-haeder">
      <h4 class="mt-5" style="float: left">Data User</h4>
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
              <th scope="col">No</th>
              <th scope="col">Nama</th>
              <th scope="col">Alamat</th>
              <th scope="col">No Handphone</th>
              <th scope="col">Jenis Kelamin</th>
              <th scope="col">Email</th>
              <th scope="col">Pekerjaan</th>
              <th scope="col">Status</th>
              <th scope="col">Tanggal Lahir</th>
              <th scope="col">Agama</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @php
                  $no = 1;
              @endphp
              @foreach ($data as $item)
              <tr>
                  <td style="width: 10%">{{ $no++                    }}</td>
                  <td style="width: 10%">{{ $item['nama']}}</td>
                  <td style="width: 10%">{{ $item['alamat']}}</td>
                  <td style="width: 10%">{{ $item['no_hp'] }}</td>
                  <td style="width: 10%">{{ $item['jk'] }}</td>
                  <td style="width: 10%">{{ $item['email'] }}</td>
                  <td style="width: 10%">{{ $item['pekerjaan'] }}</td>
                  <td style="width: 10%">{{ $item['status'] }}</td>
                  <td style="width: 10%">{{ $item['tgl_lahir'] }}</td>
                  <td style="width: 10%">{{ $item['agama'] }}</td>
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
        <h5 class="modal-title" id="exampleModalLabel">Data User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formData" onsubmit="return false">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <input type="hidden" name="id" id="dataId">
            <input type="hidden" name="user_id" id="user_id" value="1">
            <div class="col-md-12">
              <label class="form-label">Nama</label>
              <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" required>
              <span class="text-danger error-msg small" id="nama-alert"></span>
            </div>
            <div class="col-md-12">
              <label class="form-label">Alamat</label>
              <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" required>
              <span class="text-danger error-msg small" id="alamat-alert"></span>
            </div>
            <div class="col-md-12">
              <label class="form-label">No Handphone</label>
              <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="No Handphone" required>
              <span class="text-danger error-msg small" id="no_hp-alert"></span>
            </div>
            <div class="col-md-12">
              <label class="form-label">Jenis Kelamin</label>
              <select name="jk" id="jk" class="form-control">
                <option value="" selected disabled>--pilih--</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
              <span class="text-danger error-msg small" id="jk-alert"></span>
            </div>
            <div class="col-md-12">
              <label class="form-label">Email</label>
              <input type="text" class="form-control" name="email" id="email" placeholder="Email" required>
              <span class="text-danger error-msg small" id="email-alert"></span>
            </div>
            <div class="col-md-12">
              <label class="form-label">Pekerjaan</label>
              <input type="text" class="form-control" name="pekerjaan" id="pekerjaan" placeholder="Pekerjaan" required>
              <span class="text-danger error-msg small" id="pekerjaan-alert"></span>
            </div>
            <div class="col-md-12">
              <label class="form-label">Status</label>
              <input type="text" class="form-control" name="status" id="status" placeholder="Status" required>
              <span class="text-danger error-msg small" id="status-alert"></span>
            </div>
            <div class="col-md-12">
              <label class="form-label">Tanggal Lahir</label>
              <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" placeholder="Tanggal Lahir" required>
              <span class="text-danger error-msg small" id="tgl_lahir-alert"></span>
            </div>
            <div class="col-md-12">
              <label class="form-label">Agama</label>
              <input type="text" class="form-control" name="agama" id="agama" placeholder="Agama" required>
              <span class="text-danger error-msg small" id="agama-alert"></span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btn-simpan">Tambah</button>
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
            $.get(`${baseUrl}/api/v1/profile/` + _id, function (res) {
                $('.modal-title' ).html ("Formulir Edit Data" );
                $('#btn-simpan'  ).val  ("edit-user"          );
                $('#modal-data'  ).modal('show'               );
                $('#nama').val  (res.data.nama);
                $('#alamat').val  (res.data.alamat);
                $('#no_hp').val  (res.data.no_hp);
                $('#jk').val  (res.data.jk);
                $('#email').val  (res.data.email);
                $('#pekerjaan').val  (res.data.pekerjaan);
                $('#status').val  (res.data.status);
                $('#tgl_lahir').val  (res.data.tgl_lahir);
                $('#agama').val  (res.data.agama);
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
                    url     : `${baseUrl}/api/v1/profile`,
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

        $(document).on('click', '#btn-hapus', function() {
            let _id = $(this).data('id');
            let url = `${baseUrl}/api/v1/profile/` + _id;
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