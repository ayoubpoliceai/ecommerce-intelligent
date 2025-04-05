@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Produits</h5>
                <p class="card-text">{{ $stats['products'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Catégories</h5>
                <p class="card-text">{{ $stats['categories'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Commandes</h5>
                <p class="card-text">{{ $stats['orders'] }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Utilisateurs</h5>
                <p class="card-text">{{ $stats['users'] }}</p>
            </div>
        </div>
    </div>
</div>

<h2>Commandes récentes</h2>
@if($recentOrders->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td>{{ number_format($order->total_price, 2) }} €</td>
                        <td>{{ $order->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p>Aucune commande récente.</p>
@endif
@endsection