  @extends('layout.Base')
  @section('content')
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4 class="mt-5" style="float: left">Data Lampiran</h4>
        <button style="float: right" 
                id="createData"
                type="button" 
                class="btn btn-primary mt-5"
                id="createData">
          Tambah Data
        </button>
      </div>
      <div class="card-body">
        <table id="table-data" class="table table-striped table-hover">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Foto KTP</th>
              <th scope="col">Foto Kartu Berobat</th>
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
              <td style="width: 10%">{{ $item->foto_ktp }}</td>
              <td style="width: 10%">{{ $item->foto_kartu_berobat }}</td>
              <td style="width: 10%">
                <button class="editItem btn btn-info btn-sm" 
                        data-id="{{ $item->id }}">
                  Edit
                </button>
                <button class="btn btn-sm btn-danger btn-hapus" 
                        data-id="{{ $item->id }}">
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
          <h5 class="modal-title" id="exampleModalLabel">Data Attachment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="formData" enctype="multipart/form-data" onsubmit="return false">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" name="id" id="dataId">
              <div class="col-md-12">
                <label class="form-label">Foto KTP</label>
                <input type="file" class="form-control" name="foto_ktp" id="foto_ktp" placeholder="foto ktp" required>
                <span class="text-danger error-msg small" id="foto_ktp-alert"></span>
              </div>
              <div class="col-md-12">
                <label class="form-label">Foto Kartu Berobat</label>
                <input type="file" class="form-control" name="foto_kartu_berobat" id="foto_kartu_berobat" placeholder="foto kartu berobat" required>
                <span class="text-danger error-msg small" id="foto_kartu_berobat-alert"></span>
              </div>
              <span class="text-danger small" id="nama-alert"></span>
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

    $('#createData').click(function () {
      $('.modal-title').html("Formulir Tambah Data");
      $('#btn-simpan').val("create-Item");
      $('#dataId').val('');
      $('#formData').trigger("reset");
      $('#modal-data').modal('show');
      $('#nama-alert').html('');
    });

    $('body').on('click', '.editItem', function () {
      var _id = $(this).data('id');
      $.get(`${baseUrl}/api/v1/attachment/` + _id, function (res) {
        $('.modal-title').html("Formulir Edit Data");
        $('#btn-simpan').val("edit-user");
        $('#modal-data').modal('show');
        $('#foto_ktp').val(res.data.foto_ktp);
        $('#foto_kartu_berobat').val(res.data.foto_kartu_berobat);
        $('#dataId').val(res.data.id);
      })
    });

    $('#btn-simpan').click(function (e) {
      e.preventDefault();
      let submitButton = $(this);
      submitButton.html('Simpan');

      if (!submitButton.prop('disabled')) {
        let formData = new FormData($('#formData')[0]);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        let id = $('#dataId').val();

        let url = (id) ? `${baseUrl}/api/v1/attachment/${id}` : `${baseUrl}/api/v1/attachment`;
        let method = (id) ? 'PUT' : 'POST';

        $.ajax({
          data: formData,
          url: url,
          type: method, // Ganti 'PUT' atau 'POST' sesuai dengan mode edit atau create
          dataType: 'json',
          contentType: false,
          processData: false,
          success: function (result) {
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
          error: function (result) {
            submitButton.prop('disabled', false);
            if (result.status == 422) {
              let data = result.responseJSON;
              let errorRes = data.errors;
              if (errorRes.length >= 1) {
                $('#foto_ktp-alert').html(errorRes.data.foto_ktp);
                $('#foto_kartu_berobat-alert').html(errorRes.data.foto_kartu_berobat);
              }
            } else {
              let msg = 'Sedang pemeliharaan server';
              iziToast.error(msg);
            }
          }
        });
      }
    });

    $('body').on('click', '.btn-hapus', function() {
      let _id = $(this).data('id');
      let url = `${baseUrl}/api/v1/attachment/` + _id;
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
            type: 'DELETE',
            success: function (result) {
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
            error: function (result) {
              let msg;
              if (result.responseJSON) {
                let data = result.responseJSON;
                message = data.message;
              } else {
                msg = 'Sedang pemeliharaan server';
              }
              iziToast.error(msg);
            }
          });
        }
      });
    });
  </script>
  @endsection
