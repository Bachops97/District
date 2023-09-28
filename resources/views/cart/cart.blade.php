@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Cart listing') }}</div>
                <div class="card-body">
                    @if(count($cartItems) > 0)
                    <div class="row">
                        @foreach ($cartItems as $cartItem)
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $cartItem->product->name }}</h5>
                                    <p class="card-text">Description: {{ $cartItem->product->description }}</p>
                                    <p class="card-text">Price: ${{ $cartItem->product->price }}</p>
                                    <form action="{{ route('cart.update', ['cartItem' => $cartItem->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        @php
                                            $total = $cartItem->product->quantities + $cartItem->quantity;
                                        @endphp
                                        <div class="input-group mb-3">
                                            <input type="number" name="quantity" class="form-control" value="{{ $cartItem->quantity }}" min="1" max="{{ $total }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                    <form action="{{ route('cart.remove', ['cartItem' => $cartItem->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Checkout</button>
                    </form>
                    @else
                    <div>{{ __('Your cart is empty.') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
