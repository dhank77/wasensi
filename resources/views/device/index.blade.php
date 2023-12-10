@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Daftar Device</span>
                    <div class="float-right">
                        <a href="{{ route('device.add') }}" class="btn btn-primary">Tambah</a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">No HP</th>
                                <th scope="col">Session ID</th>
                                <th scope="col">Status</th>
                                <th scope="col">Training</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Scan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($devices as $key => $device)
                                
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $device->no_hp }}</td>
                                    <td>{{ $device->session }}</td>
                                    <td>{{ get_status($device->session) }}</td>
                                    <td>
                                        @if($device->is_training == 0)
                                            <div class="btn btn-sm btn-danger"><b>Tidak</b></div>
                                        @else
                                            <div class="btn btn-sm btn-success"><b>Ya</b></div>
                                        @endif
                                    </td>
                                    <td>
                                        {{ date("d-m-Y", strtotime($device->created_at)) }}
                                        @if($device->is_training == 1)
                                            @php
                                                $selisih_hari = 60 - floor((strtotime(date("Y-m-d")) - strtotime($device->created_at)) / (60 * 60 * 24));   
                                            @endphp
                                            <span class="text-danger fw-bold">(Sisa {{ $selisih_hari }} Hari)</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('device.scan', $device->id) }}" class="btn btn-sm btn-success">Scan</a>
                                        <a onclick="return confirm('anda yakin?')" href="{{ route('device.delete', $device->id) }}" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
@endpush

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $("#table").DataTable({});
    </script>
@endpush
