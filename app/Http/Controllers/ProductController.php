<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    
    public function index()
    {
        $products = QueryBuilder::for(Product::class)
            ->allowedFilters(['name', 'description', 'price'])
            ->allowedSorts(['name', 'price'])
            ->defaultSort('name') // Set the default sort order for products
            ->paginate(10);

        return response()->json(['data' => $products], Response::HTTP_OK);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the accepted image formats and maximum file size as needed.
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName); // Store the image in the "public/images" directory.
    
            $productData = $request->except('image');
            $productData['image'] = $imageName;
    
            $product = Product::create($productData);
    
            return response()->json(['message' => 'Product created successfully', 'data' => $product], 201);
        }
    
        return response()->json(['message' => 'Image not provided.'], 400);
    }

    
    public function show(Product $product)
    {
        return response()->json(['data' => $product]);
    }



    public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
    ]);

    if ($request->hasFile('image')) {
        // If a new image is provided, update it
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust image validation rules
        ]);

        $currentImage = $product->image;
        if ($currentImage) {
            // Delete the current image if it exists
            Storage::delete('public/images/' . $currentImage);
        }

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/images', $imageName);

        $product->image = $imageName;
    }

    // Update other product fields
    $product->update($request->except('image'));

    return response()->json(['message' => 'Product updated successfully', 'data' => $product]);
}


    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
