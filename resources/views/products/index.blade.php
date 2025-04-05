@extends('layouts.app')

@section('title', 'Nos produits')

@section('content')
<h1 class="mb-4">Nos produits</h1>

<div class="row">
    <!-- Sidebar pour les filtres -->
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Filtres</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Catégorie</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="search" class="form-label">Recherche</label>
                        <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="sort" class="form-label">Trier par</label>
                        <select class="form-select" id="sort" name="sort">
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nom (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nom (Z-A)</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix (croissant)</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix (décroissant)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Appliquer</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Grille de produits -->
    <div class="col-md-9">
        @if($products->count() > 0)
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            @if($product->photo)
                                <img src="{{ asset('storage/' . $product->photo) }}" class="card-img-top" alt="{{ $product->name }}">
                            @else
                                <div class="bg-light p-4 text-center">Pas d'image</div>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-truncate">{{ $product->description }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <span class="h5 mb-0">{{ number_format($product->price, 2) }} €</span>
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-primary">Voir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @else
            <div class="alert alert-info">
                Aucun produit trouvé. Essayez de modifier vos critères de recherche.
            </div>
        @endif
    </div>
</div>
@endsection