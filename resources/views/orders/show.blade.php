@extends('layouts.admin')

@section('content')
<h1 class="mb-4">Commande #{{ $order->id }}</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<p><strong>Client :</strong> {{ $order->user->name }}</p>
<p><strong>Date :</strong> {{ $order->date->format('d/m/Y') }}</p>
<p><strong>Adresse :</strong> {{ $order->address }}</p>
<p><strong>Total :</strong> {{ number_format($order->total_price, 2) }} €</p>

<form method="POST" action="{{ route('admin.orders.status', $order) }}" class="mb-3">
    @csrf
    @method('PATCH')
    <label>Changer le statut :</label>
    <div class="d-flex">
        <select name="status" class="form-select w-auto me-2">
            @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
        <button class="btn btn-primary">Mettre à jour</button>
    </div>
</form>

<h4 class="mt-4">Produits commandés :</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order->items as $item)
            <tr>
                <td>{{ $item->product->name ?? '—' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }} €</td>
                <td>{{ number_format($item->price * $item->quantity, 2) }} €</td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Retour</a>
@endsection
