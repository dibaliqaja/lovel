@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('category.category') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <a href="{{ route('categories.create') }}" class="btn btn-primary">Add New Category</a><br><br>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('category.name') }}</th>
                                <th>{{ __('category.slug') }}</th>
                                <th>{{ __('category.action') }}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse ($categories as $category => $result)
                            <tr>
                                <td>{{ $category + $categories->firstitem() }}</td>
                                <td><a href="{{ route('categories.show', $result->id) }}" >{{ $result->name }}</a></td>
                                <td>{{ $result->slug }}</td>
                                <td align="center">
                                    <a href="{{ route('categories.edit', $result->id) }}" type="button" class="btn btn-sm btn-info">Edit</i></a>
                                    <form action="{{ route('categories.destroy', $result->id) }}" method="post">
                                        @csrf @method('delete')
                                        <button href="#" type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">No categories found.</td>
                            </tr>
                            @endforelse
                          </tbody>
                    </table>
                </div>
                <div class="m-3">
                    <nav aria-label="Page navigation categories">
                        {{ $categories->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
