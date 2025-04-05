@extends('layouts.admin')

@section('content')
<h1>Ajouter un produit</h1>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>Nom</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label>Prix (€)</label>
        <input type="number" step="0.01" name="price" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Quantité</label>
        <input type="number" name="quantity" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Catégorie</label>
        <select name="category_id" class="form-control" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Photo</label>
        <input type="file" name="photo" class="form-control">
    </div>

    <button class="btn btn-success">Créer</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection
