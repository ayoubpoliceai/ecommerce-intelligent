@extends('layouts.admin')

@section('content')
<h1 class="h3 mb-4 text-gray-800">{{ $category->name }}</h1>

<p><strong>Description :</strong> {{ $category->description ?? 'Aucune' }}</p>

<h5>Produits dans cette catégorie :</h5>
<ul class="list-group mb-4">
    @forelse ($products as $product)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $product->name }}
            <span>{{ number_format($product->price, 2) }} €</span>
        </li>
    @empty
        <li class="list-group-item">Aucun produit associé</li>
    @endforelse
</ul>

<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Retour</a>
@endsection
