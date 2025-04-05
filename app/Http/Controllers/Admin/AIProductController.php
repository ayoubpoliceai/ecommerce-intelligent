<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Services\MistralAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AIProductController extends Controller
{
    protected $aiService;

    public function __construct(MistralAIService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function index()
    {
        $categories = Category::all();
        return view('admin.ai-products.index', compact('categories'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255',
        ]);

        try {
            $category = Category::findOrFail($request->category_id);
            $productData = $this->aiService->generateProductDescription($category->name, $request->product_name);
            $categories = Category::all();

            // Changed to use the preview view instead of index
            return view('admin.ai-products.preview', compact('productData', 'category', 'categories'));
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur génération : ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        $filename = 'products/' . Str::slug($request->name) . '.png';

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
            'photo' => $filename,
        ]);

        return redirect()->route('admin.products.show', $product->id)
            ->with('success', 'Produit IA enregistré.');
    }
}