@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Welcome') }} {{ auth()->user()->name }} </div>
                <div class="card-body">
                    <a class="btn btn-primary" href="{{ route('products') }}">{{ __('View all products') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

