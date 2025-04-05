@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="mb-4">
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i> Retour aux produits
    </a>
</div>

<div class="row">
    <div class="col-md-5">
        @if($product->photo)
            <img src="{{ asset('storage/' . $product->photo) }}" class="img-fluid rounded" alt="{{ $product->name }}">
        @else
            <div class="bg-light p-5 text-center rounded">
                <i class="fas fa-image fa-4x text-muted"></i>
                <p class="mt-3 text-muted">Pas d'image disponible</p>
            </div>
        @endif
    </div>
    
    <div class="col-md-7">
        <h1>{{ $product->name }}</h1>
        <p class="text-muted">
            Catégorie: <a href="{{ route('products.index', ['category_id' => $product->category_id]) }}">{{ $product->category->name }}</a>
        </p>
        
        <div class="mb-4">
            <h2 class="h3 text-primary">{{ number_format($product->price, 2) }} €</h2>
            
            <p class="mb-2">
                État du stock: 
                @if($product->quantity > 10)
                    <span class="badge bg-success">En stock</span>
                @elseif($product->quantity > 0)
                    <span class="badge bg-warning">Stock limité ({{ $product->quantity }} restants)</span>
                @else
                    <span class="badge bg-danger">Rupture de stock</span>
                @endif
            </p>
        </div>
        
        <div class="mb-4">
            <h3 class="h5">Description</h3>
            <p>{{ $product->description }}</p>
        </div>
        
        @if($product->quantity > 0)
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-auto">
                        <label for="quantity" class="col-form-label">Quantité</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" id="quantity" name="quantity" class="form-control" min="1" max="{{ $product->quantity }}" value="1">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-cart-plus me-2"></i> Ajouter au panier
                </button>
            </form>
        @else
            <button class="btn btn-secondary" disabled>
                Indisponible
            </button>
        @endif
    </div>
</div>

@if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="mt-5">
        <h2>Produits similaires</h2>
        <div class="row">
            @foreach($relatedProducts as $relatedProduct)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        @if($relatedProduct->photo)
                            <img src="{{ asset('storage/' . $relatedProduct->photo) }}" class="card-img-top" alt="{{ $relatedProduct->name }}">
                        @else
                            <div class="bg-light p-4 text-center">Pas d'image</div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="h5 mb-0">{{ number_format($relatedProduct->price, 2) }} €</span>
                                <a href="{{ route('products.show', $relatedProduct->id) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection