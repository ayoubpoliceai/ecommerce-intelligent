@extends('layouts.admin')

@section('content')
<h1>Modifier la catégorie</h1>

<form action="{{ route('admin.categories.update', $category) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name">Nom</label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="description">Description</label>
        <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Mettre à jour</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection
