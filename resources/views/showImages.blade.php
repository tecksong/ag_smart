@extends('layouts.app')
@section('title', 'Show All Image')

<script>
    var images = @json($images);
</script>

@section('content')
    <div class="container-fluid">
        <div class="container">
            <h1>Images</h1>
            <div class="row">
                @foreach ($images as $image)
                    <div class="col-12 col-sm-6 col-md-4">
                        <img src="{{ $image['url'] }}" alt="{{ $image['fileName'] }}" class="img-fluid img-thumbnail w-100"
                            style="height: 300px; object-fit: contain;">
                        <p>{{ $image['name'] }}</p>
                    </div>
                @endforeach
            </div>
            <div>
                {{ $images->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
