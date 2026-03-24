<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
                        ->where('is_active', true)
                        ->firstOrFail();

        return view('products.show', ['product' => $product]);
    }

    public function index()
    {
        // Ambil semua produk aktif dari database
        $products = Product::where('is_active', true)
                        ->orderBy('category')
                        ->get();

        return view('products', compact('products'));
    }

    /**
     * Mengubah status produk unggulan
     */
    public function toggleFeatured(Product $product)
    {
        $product->update([
            'is_featured' => !$product->is_featured
        ]);

        $status = $product->is_featured ? 'berhasil dijadikan produk unggulan' : 'dihapus dari produk unggulan';
        return redirect()->back()->with('success', "Produk {$product->name} {$status}.");
    }
}