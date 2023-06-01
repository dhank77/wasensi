@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Tambah Member</span>
                </div>

                <div class="card-body">
                    <form action="{{ route('member.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ $member->id }}">
                        <div class="form-group mb-4">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" value="{{ $member->name }}" id="name" name="name" aria-describedby="name" placeholder="Enter Nama">
                        </div>
                        <div class="form-group mb-4">
                            <label for="no_pj">No HP PJ</label>
                            <input type="number" class="form-control" value="{{ $member->no_pj }}" id="no_pj" name="no_pj" aria-describedby="no_pj" placeholder="Enter No HP PJ">
                        </div>
                        <div class="form-group mb-4">
                            <label for="notif_pj">Notif PJ</label>
                            <input type="number" class="form-control" value="{{ $member->notif_pj }}" id="notif_pj" name="notif_pj" aria-describedby="notif_pj" placeholder="Enter Status">
                        </div>
                        <div class="form-group mb-4">
                            <label for="code">Code ID</label>
                            <input type="text" class="form-control" value="{{ $member->code }}" id="code" name="code" aria-describedby="code" placeholder="Enter Code ID">
                        </div>
                        <div class="form-group mb-4">
                            <label for="expired_date">Expired Date</label>
                            <input type="date" class="form-control" value="{{ $member->expired_date }}" id="expired_date" name="expired_date" aria-describedby="expired_date" placeholder="Enter Expired Date">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
