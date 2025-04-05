@extends('layouts.admin')

@section('content')
<h1>Modifier le produit</h1>

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="mb-3">
        <label>Prix (€)</label>
        <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}" required>
    </div>

    <div class="mb-3">
        <label>Quantité</label>
        <input type="number" name="quantity" class="form-control" value="{{ $product->quantity }}" required>
    </div>

    <div class="mb-3">
        <label>Catégorie</label>
        <select name="category_id" class="form-control" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Photo (laisser vide pour ne pas changer)</label>
        <input type="file" name="photo" class="form-control">
    </div>

    <button class="btn btn-primary">Mettre à jour</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection
