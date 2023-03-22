@extends('layouts.app')

@section('title', 'Create Image')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Image</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('image.create') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="url">URL:</label>
                            <input type="text" name="url" id="url" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Image</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
