@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-3">
                <div class="form-group">
                    <label for="name">{{ __('category.name') }}</label>
                    <p>{{ $category->name }}</p>
                </div>
                <div class="form-group">
                    <label for="slug">{{ __('category.slug') }}</label>
                    <p>{{ $category->slug }}</p>
                </div>
                <div class="form-group mt-3">
                    <a href="{{ route('categories.index') }}" class="btn btn-danger">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
