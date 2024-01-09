@extends('layout.Base')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 d-flex mb-4">
                    <h4 class="col-sm-10">Data History Registrasi</h4>
                    <div class="col-sm-2 d-flex flex-row-reverse">
                    </div>
                </div>
                <table class="table table-striped table-hover" id="table-data">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Taggal</th>
                            <th scope="col">Visit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($response as $item)
                            <tr>
                                <td style="width: 10%">{{ $no++ }}</td>
                                <td style="width: 10%">{{ $item['ket'] }}</td>
                                <td style="width: 10%">{{ $item['tgl'] }}</td>
                                <td style="width: 10%">{{ $item['visit_sugest'] == 1 ? 'Selesai' : 'Belum' }}</td>
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
    </script>
@endsection
