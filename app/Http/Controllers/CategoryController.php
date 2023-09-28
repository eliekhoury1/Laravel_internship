<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class CategoryController extends Controller
{
   

    public function index()
    {
        $categories = QueryBuilder::for(Category::class)
            ->allowedFilters(['name'])
            ->allowedSorts(['name'])
            ->defaultSort('name') // Set the default sort order for categories
            ->paginate(10);

        return response()->json(['data' => $categories], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($data);

        return response()->json(['category' => $category], 201);
    }

    public function show(Category $category)
    {
        return response()->json(['category' => $category], 200);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($data);

        return response()->json(['message' => 'Category updated successfully'], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], 204);
    }
}
