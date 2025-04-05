@extends('layouts.admin')

@section('content')
<h1 class="mb-4">Créer une catégorie</h1>

<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name">Nom</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="description">Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Créer</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection
