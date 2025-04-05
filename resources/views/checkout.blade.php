@extends('layouts.app')

@section('title', 'Finaliser votre commande')

@section('content')
<h1 class="mb-4">Finaliser votre commande</h1>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Adresse de livraison</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('orders.place') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom et prénom</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Adresse</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">Ville</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}" required>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="postal_code" class="form-label">Code postal</label>
                            <input type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required>
                            @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Numéro de téléphone</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="mb-0">Méthode de paiement</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_method_card" value="card" checked>
                                <label class="form-check-label" for="payment_method_card">
                                    Carte bancaire
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_method_paypal" value="paypal">
                                <label class="form-check-label" for="payment_method_paypal">
                                    PayPal
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-lock me-2"></i> Confirmer la commande
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Résumé de la commande</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>
                                        {{ $item['name'] }}
                                        <small class="text-muted d-block">{{ $item['quantity'] }} x {{ number_format($item['price'], 2) }} €</small>
                                    </td>
                                    <td class="text-end">{{ number_format($item['subtotal'], 2) }} €</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sous-total</th>
                                <td class="text-end">{{ number_format($total, 2) }} €</td>
                            </tr>
                            <tr>
                                <th>Livraison</th>
                                <td class="text-end">Gratuit</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td class="text-end fw-bold">{{ number_format($total, 2) }} €</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection