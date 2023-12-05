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
                            <label for="no_hp">Training</label>
                            <select name="is_training" id="is_training" class="form-control">
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
