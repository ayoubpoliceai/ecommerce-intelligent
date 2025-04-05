@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Générateur de produit IA</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.ai-products.generate') }}" method="POST" class="card p-4 mb-4 shadow">
        @csrf
        <div class="mb-3">
            <label>Catégorie</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Choisir --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Nom du produit</label>
            <input type="text" name="product_name" class="form-control" required>
        </div>
        <button class="btn btn-primary">Générer</button>
    </form>

    @isset($productData)
        <form action="{{ route('admin.ai-products.store') }}" method="POST" class="card p-4 shadow">
            @csrf
            <input type="hidden" name="category_id" value="{{ $category->id }}">

            <div class="mb-3">
                <label>Nom</label>
                <input type="text" name="name" class="form-control" value="{{ $productData['design'] }}">
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4">{{ $productData['description'] }}</textarea>
            </div>
            <div class="mb-3">
                <label>Prix (€)</label>
                <input type="number" name="price" step="0.01" class="form-control" value="{{ $productData['prix'] }}">
            </div>
            <div class="mb-3">
                <label>Quantité</label>
                <input type="number" name="quantity" class="form-control" value="{{ $productData['quantite'] }}">
            </div>
            <div class="mb-3">
                <label>Image (nom)</label>
                <input type="text" class="form-control" disabled value="{{ \Str::slug($productData['design']) }}.png">
            </div>
            <button class="btn btn-success">Valider & Enregistrer</button>
        </form>
    @endisset
</div>
@endsection
