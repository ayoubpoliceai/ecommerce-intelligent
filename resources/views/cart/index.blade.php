@extends('layouts.app')

@section('title', 'Votre panier')

@section('content')
<h1 class="mb-4">Votre panier</h1>

@if(count($items) > 0)
    <div class="table-responsive mb-4">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 100px;">Image</th>
                    <th>Produit</th>
                    <th class="text-center">Prix</th>
                    <th class="text-center">Quantité</th>
                    <th class="text-end">Total</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                            @if($item['photo'])
                                <img src="{{ asset('storage/' . $item['photo']) }}" alt="{{ $item['name'] }}" class="img-thumbnail" style="max-width: 80px;">
                            @else
                                <div class="bg-light text-center p-2" style="width: 80px; height: 80px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('products.show', $item['id']) }}">{{ $item['name'] }}</a>
                        </td>
                        <td class="text-center">{{ number_format($item['price'], 2) }} €</td>
                        <td class="text-center" style="width: 150px;">
                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="d-flex align-items-center justify-content-center">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm" style="width: 60px;">
                                <button type="submit" class="btn btn-sm btn-outline-secondary ms-2">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </form>
                        </td>
                        <td class="text-end">{{ number_format($item['subtotal'], 2) }} €</td>
                        <td class="text-center">
                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end fw-bold">Total :</td>
                    <td class="text-end fw-bold">{{ number_format($total, 2) }} €</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <div class="d-flex justify-content-between">
        <form action="{{ route('cart.clear') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                <i class="fas fa-trash me-2"></i> Vider le panier
            </button>
        </form>
        
        <div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-shopping-basket me-2"></i> Continuer les achats
            </a>
            <a href="{{ route('orders.place') }}" class="btn btn-success">
                <i class="fas fa-check me-2"></i> Passer commande
            </a>
        </div>
    </div>
@else
    <div class="alert alert-info">
        <p>Votre panier est vide.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary mt-2">
            <i class="fas fa-shopping-basket me-2"></i> Parcourir les produits
        </a>
    </div>
@endif
@endsection