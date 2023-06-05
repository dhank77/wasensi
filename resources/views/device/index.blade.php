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
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">No HP</th>
                                <th scope="col">Session ID</th>
                                <th scope="col">Status</th>
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
