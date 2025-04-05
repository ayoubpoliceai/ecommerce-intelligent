<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    // Statistiques
    $stats = [
        'orders' => Order::count(),
        'products' => Product::count(), 
        'users' => User::count(),
        'categories' => Category::count(),
        'revenue' => Order::where('status', 'completed')->sum('total_price'),
    ];
    
    // Commandes récentes
    $recentOrders = Order::with('user')
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();
                        
    // Produits à faible stock (moins de 5 unités)
    $lowStockProducts = Product::where('quantity', '<', 5)
                            ->with('category')
                            ->get();
    
    return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts'));
}
}