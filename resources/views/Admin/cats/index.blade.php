@extends('admin.layouts.base')

@section('mainContent')
    <h1>Category</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Slug</th>
                <th>Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cats as $cat)
                <tr data-id="{{ $cat->id }}">
                    <td>{{ $cat->id }}</td>
                    <td>{{ $cat->slug }}</td>
                    <td>{{ $cat->name }}</td>
                    <td>{{ $cat->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
