@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Import Data</div>

                <div class="card-body">
                    <form action="{{ route('import.alumni') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="alumni_file">Import Data Alumni</label>
                            <input type="file" class="form-control" name="file" id="alumni_file" required>
                            <small class="form-text text-muted">Gunakan file Excel format alumni</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Import Alumni</button>
                    </form>

                    <hr>

                    <form action="{{ route('import.tracer') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="tracer_file">Import Data Tracer & Kepuasan</label>
                            <input type="file" class="form-control" name="file" id="tracer_file" required>
                            <small class="form-text text-muted">Gunakan file Excel format tracer</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Import Tracer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection