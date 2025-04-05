<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')
                            ->with('error', 'Votre panier est vide.');
        }
        
        $items = [];
        $total = 0;
        
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();
        
        foreach ($products as $product) {
            if (isset($cart[$product->id])) {
                $quantity = $cart[$product->id];
                $subtotal = $product->price * $quantity;
                
                $items[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'photo' => $product->photo,
                    'subtotal' => $subtotal
                ];
                
                $total += $subtotal;
            }
        }
        
      return view('checkout', compact('items', 'total'));
    }
    
    public function placeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
        ]);
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')
                            ->with('error', 'Votre panier est vide.');
        }
        
        // Calculer le total et vérifier le stock
        $total = 0;
        $orderItems = [];
        
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();
        
        foreach ($products as $product) {
            if (isset($cart[$product->id])) {
                $quantity = $cart[$product->id];
                
                // Vérifier si le stock est suffisant
                if ($product->quantity < $quantity) {
                    return redirect()->route('cart.index')
                                    ->with('error', "Stock insuffisant pour {$product->name}.");
                }
                
                $total += $product->price * $quantity;
                
                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price
                ];
            }
        }
        
        // Créer l'adresse complète
        $fullAddress = "{$request->address}, {$request->postal_code} {$request->city}";
        
        // Créer la commande
        $order = Order::create([
            'user_id' => Auth::id(),
            'date' => Carbon::now()->toDateString(),
            'address' => $fullAddress,
            'total_price' => $total,
            'status' => 'pending',
        ]);
        
        // Créer les éléments de commande
        foreach ($orderItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
            
            // Mettre à jour le stock
            $product = Product::find($item['product_id']);
            $product->quantity -= $item['quantity'];
            $product->save();
        }
        
        // Vider le panier
        session()->forget('cart');
        
        return redirect()->route('orders.show', $order->id)
                        ->with('success', 'Votre commande a été passée avec succès !');
    }

    public function index()
{   
    $userId = Auth::id();
    $orders = Order::where('user_id', $userId)
                   ->orderBy('created_at', 'desc')
                   ->paginate(10);
    
    // Vérifier si l'utilisateur est authentifié et voir combien de commandes il a
    $totalOrders = Order::where('user_id', $userId)->count();
    
    // Ajouter ces informations à la vue pour le débogage
    return view('orders.index', compact('orders', 'userId', 'totalOrders'));
}
    
    public function show(Order $order)
    {
        // S'assurer que l'utilisateur peut voir uniquement ses propres commandes
        if ($order->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->route('orders.index')
                            ->with('error', 'Vous n\'êtes pas autorisé à voir cette commande.');
        }
        
        $order->load('items.product');
        
        return view('orders.show', compact('order'));
    }
}