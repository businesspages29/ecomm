@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 class="text-center">{{ __('Products') }}</h1>
            </div>
            <form class="d-flex">
                <input class="form-control me-2" name="search" value="{{ request()->get('search') }}" type="search"
                    placeholder="Search" aria-label="Search">
                <select class="form-select me-2" name="brand">
                    <option selected>{{ __('Select Brand') }}</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->slug }}" @if (request()->has('search') && request()->get('brand') == $brand->slug) selected @endif>
                            {{ $brand->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-outline-success me-2" type="submit">Search</button>
                <a href="{{ route('home') }}" class="btn btn-outline-danger">Reset</a>
            </form>
        </div>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-3">
                    <div class="card mt-3">
                        <img src="{{ $product->image }}" class="card-img-top" alt="test">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">{{ $product->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Brand: {{ optional($product->brand)->name }}</h6>
                            <p class="card-text">${{ $product->price }}</p>
                            <a href="{{ route('cart.add', $product->id) }}"
                                class="btn btn-warning">{{ __('Add to Cart') }}</a>
                            <a href="{{ route('products.show', $product->slug) }}"
                                class="btn btn-primary">{{ __('View') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
