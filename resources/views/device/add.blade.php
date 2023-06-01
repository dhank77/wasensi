@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span>Tambah Device</span>
                </div>

                <div class="card-body">
                    <form action="{{ route('device.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="no_hp">Nomor Handphone</label>
                            <input type="number" class="form-control" id="no_hp" name="no_hp" aria-describedby="no_hp" placeholder="Enter No Handphone">
                        </div>
                        <div class="form-group mb-4">
                            <label for="session">Session ID</label>
                            <input type="text" class="form-control" id="session" name="session" aria-describedby="session" placeholder="Enter Session ID">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
