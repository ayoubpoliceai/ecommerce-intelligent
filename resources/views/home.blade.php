@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="bg-light p-5 rounded mb-4">
    <h1 class="display-4">Bienvenue sur notre boutique en ligne</h1>
    <p class="lead">Découvrez nos produits de qualité à des prix compétitifs.</p>
    <a href="{{ route('products.index') }}" class="btn btn-primary">Voir tous les produits</a>
</div>

<h2 class="mb-4">Catégories</h2>
<div class="row mb-5">
    @foreach($categories as $category)
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">{{ $category->name }}</h5>
                <p class="card-text">{{ $category->description }}</p>
                <a href="{{ route('products.index', ['category' => $category->id]) }}" class="btn btn-outline-primary">
                    Voir les produits
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<h2 class="mb-4">Produits en vedette</h2>
<div class="row">
    @foreach($featuredProducts as $product)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            @if($product->photo)
            <img src="{{ asset('storage/' . $product->photo) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
            @else
            <div class="bg-light text-center py-5">
                <i class="bi bi-image" style="font-size: 3rem;"></i>
            </div>
            @endif
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                <div class="mt-auto">
                    <p class="card-text text-primary fw-bold">{{ number_format($product->price, 2) }} €</p>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Voir le produit</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection