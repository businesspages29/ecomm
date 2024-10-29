@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                {{ $product->name }}
            </div>
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Brand: {{ optional($product->brand)->name }}</h6>
                <p class="card-text">{{ $product->price }}</p>
                <p class="card-text">{{ __('Available Stock') }}: {{ $product->available_stock }}</p>
                <a href="#" class="card-link">Card link</a>
            </div>
        </div>
    </div>
@endsection
