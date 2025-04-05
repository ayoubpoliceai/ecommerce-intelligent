@extends('layouts.admin')

@section('content')
<h1 class="mb-4">Commandes</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Client</th>
            <th>Date</th>
            <th>Montant</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name ?? '-' }}</td>
                <td>{{ $order->date->format('d/m/Y') }}</td>
                <td>{{ number_format($order->total_price, 2) }} €</td>
                <td>
                    @php
                        switch ($order->status) {
                            case 'pending': $badge = 'warning'; break;
                            case 'processing': $badge = 'info'; break;
                            case 'shipped': $badge = 'primary'; break;
                            case 'delivered': $badge = 'success'; break;
                            case 'cancelled': $badge = 'danger'; break;
                            default: $badge = 'secondary';
                        }
                    @endphp
                    <span class="badge bg-{{ $badge }}">{{ ucfirst($order->status) }}</span>
                </td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">Voir</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center">Aucune commande trouvée.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
