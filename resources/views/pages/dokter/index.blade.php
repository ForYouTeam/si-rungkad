@extends('layout.Base')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 d-flex mb-4">
                    <h4 class="col-sm-10">Data Dokter</h4>
                    <div class="col-sm-2 d-flex flex-row-reverse">
                        <a href="{{route('dokter-add')}}" class="btn btn-primary">Tambah Data</a>
                    </div>
                </div>
                <table class="table table-striped table-hover" id="table-data">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>>
                            <th scope="col">No Handphone</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Email</th>
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
                                <td style="width: 10%">{{ $item['no_hp'] }}</td>
                                <td style="width: 10%">{{ $item['jk'] }}</td>
                                <td style="width: 10%">{{ $item['email'] }}</td>
                                <td style="width: 10%;">
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
@endsection

@section('script')
    <script>
        let baseUrl
        let btnEdit = $('.editItem')

        $(document).ready(function() {
            baseUrl = "{{ config('app.url') }}"

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#table-data').DataTable();
        });

        $(btnEdit).click(function(e) {
            var id = $(this).data('id');
            window.location.href = "{{ route('dokter-add') }}/" + id;
        });

        $(document).on('click', '#btn-hapus', function() {
            let _id = $(this).data('id');
            let url = `${baseUrl}/api/v1/doctorprofile/` + _id;
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
