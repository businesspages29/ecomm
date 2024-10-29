@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 class="text-center">{{ __('Orders') }}</h1>
            </div>
        </div>
        <div class="row">
            @foreach ($orders as $order)
                <div class="col-md-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            #{{ $order->id }} ({{ $order->created_at }}) - ${{ $order->total_amount }}
                        </div>
                        @foreach ($order->items as $item)
                            <div class="card-body">
                                <a href="{{ route('products.show', $item->product->slug) }}" class="">
                                    <h5 class="card-title font-weight-bold">{{ $item->product->name }}</h5>
                                </a>
                                <h6 class="card-subtitle mb-2 text-muted">Brand: {{ optional($item->product->brand)->name }}
                                </h6>
                                <p class="card-text">${{ $item->product->price }}</p>
                                <p class="card-text">Quantity: {{ $item->quantity }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
