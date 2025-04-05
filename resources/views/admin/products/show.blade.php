@extends('layouts.admin')

@section('content')
<h1>Détails du produit</h1>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $product->name }}</h5>
        <p class="card-text"><strong>Description:</strong> {{ $product->description }}</p>
        <p class="card-text"><strong>Prix:</strong> {{ number_format($product->price, 2) }} €</p>
        <p class="card-text"><strong>Quantité:</strong> {{ $product->quantity }}</p>
        <p class="card-text"><strong>Catégorie:</strong> {{ $product->category->name ?? '—' }}</p>

        @if ($product->photo)
            <img src="{{ asset('storage/' . $product->photo) }}" alt="Image produit" style="max-width: 200px;">
        @endif

        <div class="mt-3">
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">Modifier</a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Retour</a>
        </div>
    </div>
</div>
@endsection
