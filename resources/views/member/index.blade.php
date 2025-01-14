@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Daftar Member</span>
                    <div class="float-right">
                        <a href="{{ route('member.add') }}" class="btn btn-primary">Tambah</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">No Penanggung Jawab</th>
                                    <th scope="col">No Request</th>
                                    <th scope="col">Notif PJ</th>
                                    <th scope="col">Expired Date</th>
                                    <th scope="col">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($members as $key => $member)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ ucwords($member->name) }}</td>
                                    <td>{{ $member->code }}</td>
                                    <td>{{ $member->no_pj }}</td>
                                    <td>{{ $member->no_request }}</td>
                                    <td>{{ $member->notif_pj }}</td>
                                    <td>{{ ($member->expired_date) }}</td>
                                    <td>
                                        <a href="{{ route('member.edit', $member->id) }}" class="btn btn-sm btn-success">Edit</a>
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
