<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $items = [];
        $total = 0;
        
        if (!empty($cart)) {
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
        }
        
        return view('cart.index', compact('items', 'total'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $product = Product::findOrFail($request->product_id);
        
        if ($product->quantity < $request->quantity) {
            return back()->with('error', 'Stock insuffisant.');
        }
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id] += $request->quantity;
        } else {
            $cart[$request->product_id] = $request->quantity;
        }
        
        session()->put('cart', $cart);
        
        return back()->with('success', 'Produit ajouté au panier.');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            $product = Product::findOrFail($id);
            
            if ($product->quantity < $request->quantity) {
                return back()->with('error', 'Stock insuffisant.');
            }
            
            $cart[$id] = $request->quantity;
            session()->put('cart', $cart);
            
            return back()->with('success', 'Panier mis à jour.');
        }
        
        return back()->with('error', 'Produit non trouvé.');
    }
    
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            
            return back()->with('success', 'Produit retiré du panier.');
        }
        
        return back()->with('error', 'Produit non trouvé.');
    }
    
    public function clear()
    {
        session()->forget('cart');
        
        return back()->with('success', 'Panier vidé.');
    }
}