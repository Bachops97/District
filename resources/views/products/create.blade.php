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
                            <form method="POST" action="{{ route('product.store') }}">
                                @csrf <!-- CSRF protection -->

                                <div class="form-group">
                                    <label for="name">Product Name:</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="description">Description:</label>
                                    <textarea name="description" id="description" class="form-control" required></textarea>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="price">Price:</label>
                                    <input type="number" name="price" id="price" class="form-control" step="0.01" required>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="quantities">Quantity:</label>
                                    <input type="number" name="quantities" id="quantities" class="form-control" min="0" required>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="category">Category:</label>
                                    <select name="category[]" id="category" class="form-select" multiple>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <button type="submit" class="btn btn-primary mt-4">Create Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
