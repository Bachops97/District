@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Products Listing</div>

                <div class="card-body">
                    <div class="mb-3">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link{{ empty($selectedCategory) ? ' active' : '' }}" href="{{ route('products') }}">All</a>
                            </li>
                            @foreach ($categories as $category)
                            <li class="nav-item">
                                <a class="nav-link{{ $selectedCategory == $category->id ? ' active' : '' }}" href="{{ route('products', ['category' => $category->id]) }}">{{ $category->name }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    @if(count($products) > 0)
                    <div class="row">
                        @foreach ($products as $product)
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">Description: {{ $product->description }}</p>
                                    <p class="card-text">Price: ${{ $product->price }}</p>
                                    <p class="card-text">Quantity: {{ $product->quantities }}</p>
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                                        <!-- Quantity Input -->
                                        <div class="input-group mb-3">
                                            <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->quantities }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        {!! $products->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>
                    @else
                    <div>{{ __('There are no products available !') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
