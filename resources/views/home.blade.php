@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 d-flex justify-content-between">
            <div class="card text-white bg-primary mb-3" style="width: 18rem;">
                <div class="card-header text-center">Pesan Terkirim Hari Ini</div> 
                <div class="card-body">
                    <h5 style="font-size:50px;" class="card-title text-center">{{ number_indo($pesanHariIni) }}</h5>
                </div>
            </div>
            <div class="card text-white bg-primary mb-3" style="width: 18rem;">
                <div class="card-header text-center">Total Pesan Terkirim</div> 
                <div class="card-body">
                    <h5 style="font-size:50px;" class="card-title text-center">{{ number_indo($totalPesan) }}</h5>
                </div>
            </div>
            <div class="card text-white bg-primary mb-3" style="width: 18rem;">
                <div class="card-header text-center">Jumlah Member Aktif</div> 
                <div class="card-body">
                    <h5 style="font-size:50px;" class="card-title text-center">{{ number_indo($memberAktif) }}</h5>
                </div>
            </div>
            <div class="card text-white bg-primary mb-3" style="width: 18rem;">
                <div class="card-header text-center">Total Member</div> 
                <div class="card-body">
                    <h5 style="font-size:50px;" class="card-title text-center">{{ number_indo($totalMember) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <br>
                    <table id="table" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Member</th>
                                <th>Pesan Hari Ini</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($member->where("expired_date", ">=", date("Y-m-d")); as $key => $value)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ ucwords($value->name) }}</td>
                                    @php
                                       $pesan = get_pesan_member($value->code);
                                    @endphp
                                    <td>{{ number_indo($pesan['hari_ini']) }}</td>
                                    <td>{{ number_indo($pesan['total']) }}</td>
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
