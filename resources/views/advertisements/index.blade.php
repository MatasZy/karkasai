@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Advertisements</div>

                    <div class="card-body">
                        <a href="{{ route('advertisements.create') }}" class="btn btn-success mb-3">Add New Advertisement</a>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($advertisements as $advertisement)
                                <tr>
                                    <td>{{ $advertisement->title }}</td>
                                    <td>{{ $advertisement->description }}</td>
                                    <td>
                                        @if (auth()->check() && $advertisement->user_id === auth()->user()->id)
                                            <a href="{{ route('advertisements.edit', $advertisement) }}" class="btn btn-primary">Edit</a>
                                            <form action="{{ route('advertisements.destroy', $advertisement) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this advertisement?')">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
