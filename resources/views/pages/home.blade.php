@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        @foreach ($cabanas as $cabana)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ $cabana->image ? (str_starts_with($cabana->image, 'images/') ? asset($cabana->image) : asset('storage/'.$cabana->image)) : 'https://via.placeholder.com/400x200' }}" class="card-img-top" alt="{{ $cabana->name }}">
                    <div class="card-body">
                        <h5>{{ $cabana->name }}</h5>
                        <p>RM {{ $cabana->price_daily }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
