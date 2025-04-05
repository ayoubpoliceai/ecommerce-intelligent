@extends('layouts.admin')

@section('content')
<h1 class="mb-4">Catégories</h1>

<a href="{{ route('admin.categories.create') }}" class="btn btn-success mb-3">+ Nouvelle catégorie</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Produits</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description }}</td>
                <td>{{ $category->products_count }}</td>
                <td>
                    <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-info btn-sm">Voir</a>
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Supprimer ?')" class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">Aucune catégorie.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
