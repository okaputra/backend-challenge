<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tb_produk;

class ProductController extends Controller
{
    public function index()
    {
        $products = tb_produk::all();
        return response()->json([
            'messages' => 'Fetch data successfully',
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'nama_produk' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'diskon' => 'nullable|numeric',
        ]);

        // Extract product data from the request
        $productData = $request->all();

        // Calculate and add the discounted price if discount is provided
        if (isset($productData['diskon'])) {
            $productData['discounted_price'] = $this->calculateDiscountedPrice($productData['harga'], $productData['diskon']);
        }

        // Create a new product instance
        $product = tb_produk::create($productData);

        // Return a JSON response indicating success
        return response()->json(['message' => 'Product created successfully', 'data' => $product], 201);
    }

    public function show($id)
    {
        // Return the specified product
        $produk = tb_produk::find($id);
        return response()->json([
            'messages' => 'Fetch Data Specific Product',
            'product' => $produk
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'nama_produk' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'diskon' => 'nullable|numeric',
        ]);

        // Extract product data from the request
        $productData = $request->all();

        // Calculate and add the discounted price if discount is provided
        if (isset($productData['diskon'])) {
            $productData['discounted_price'] = $this->calculateDiscountedPrice($productData['harga'], $productData['diskon']);
        }

        $product = tb_produk::find($id);
        if (!$product) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        // Update the specified product with the new data
        $product->update($productData);

        // Return a JSON response indicating success
        return response()->json(['message' => 'Product updated successfully', 'data' => $product], 200);
    }

    public function destroy($id)
    {
        // Delete the specified product from the database
        $product = tb_produk::find($id);
        $product->delete();

        // Return a JSON response indicating success
        return response()->json(['message' => 'Product deleted successfully'], 204);
    }

    // Calculate the discounted price based on the original price and discount percentage.
    public function calculateDiscountedPrice($price, $discount)
    {
        // Calculate the discounted price
        $discountedPrice = $price - ($price * ($discount / 100));
        return $discountedPrice;
    }
}
