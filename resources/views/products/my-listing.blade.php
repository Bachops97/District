@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Products Listing</div>

                <div class="card-body">
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

                                        <div class="btn-group">
                                            <a href="{{ route('product.edit', ['product' => $product->id]) }}" style="border-radius: 6px;" class="btn btn-primary">Edit</a>

                                            <form action="{{ route('product.destroy', ['product' => $product->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger mx-2" onclick="return confirm('Are you sure you want to delete this product?')">Remove</button>
                                            </form>

                                        </div>
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
