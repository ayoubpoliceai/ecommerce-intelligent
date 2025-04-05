@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Prévisualisation du produit généré</h1>
    
    <div class="mb-3">
        <a href="{{ route('admin.ai-products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour au générateur
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Produit généré par IA</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.ai-products.store') }}" method="POST">
                @csrf
                <input type="hidden" name="category_id" value="{{ $category->id }}">
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nom du produit</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $productData['design'] ?? '' }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" required>{{ $productData['description'] ?? '' }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Prix (€)</label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ $productData['prix'] ?? '' }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="quantity" class="form-label">Quantité en stock</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ $productData['quantite'] ?? 10 }}" required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Catégorie</label>
                    <input type="text" class="form-control" value="{{ $category->name }}" disabled>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Image (sera générée automatiquement)</label>
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px; width: 100%;">
                        <i class="fas fa-image fa-4x text-secondary"></i>
                    </div>
                    <small class="text-muted">L'image sera nommée: {{ \Str::slug($productData['design'] ?? 'produit') }}.png</small>
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.ai-products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Retour
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Ajouter au catalogue
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Données brutes générées</h5>
        </div>
        <div class="card-body">
            <pre class="bg-light p-3 rounded"><code>{{ json_encode($productData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
        </div>
    </div>
</div>
@endsection