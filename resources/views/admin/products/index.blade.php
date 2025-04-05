@extends('layouts.admin')

@section('content')
<h1 class="mb-4">Liste des produits</h1>

<a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">+ Nouveau produit</a>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Catégorie</th>
            <th>Prix</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name ?? '—' }}</td>
            <td>{{ number_format($product->price, 2) }} €</td>
            <td>{{ $product->quantity }}</td>
            <td>
                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info btn-sm">Voir</a>
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm">Modifier</a>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce produit ?')">Supprimer</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5">Aucun produit trouvé.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
