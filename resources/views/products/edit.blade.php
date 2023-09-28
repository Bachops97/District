@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create your product') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form method="POST" action="{{ route('product.update', ['product' => $product->id]) }}">
                                @csrf <!-- CSRF protection -->
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">Product Name:</label>
                                    <input type="text" name="name" id="name" class="form-control" required value="{{ isset($product) ? $product->name : old('name') }}">
                                </div>

                                <div class="form-group mt-2">
                                    <label for="description">Description:</label>
                                    <textarea name="description" id="description" class="form-control" required>{{ isset($product) ? $product->description : old('description') }}</textarea>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="price">Price:</label>
                                    <input type="number" name="price" id="price" class="form-control" step="0.01" required value="{{ isset($product) ? $product->price : old('price') }}">
                                </div>

                                <div class="form-group mt-2">
                                    <label for="quantities">Quantity:</label>
                                    <input type="number" name="quantities" id="quantities" class="form-control" min="0" required value="{{ isset($product) ? $product->quantities : old('quantities') }}">
                                </div>

                                <div class="form-group mt-2">
                                    <label for="category">Category:</label>
                                    <select name="category[]" id="category" class="form-select" multiple>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ (isset($product) && in_array($category->id, $product->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary mt-4">Edit Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
