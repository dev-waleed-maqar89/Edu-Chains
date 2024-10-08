<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CategoryResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    public function __construct() {}
    public function index()
    {
        $categories = CategoryResource::collection(Category::all());
        return $this->apiSuccess(compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = new CategoryResource(Category::create($request->all()));
        return $this->apiSuccess(compact('category'));
    }

    public function show($id)
    {
        $category = new CategoryResource(Category::findOrFail($id));
        return $this->apiSuccess(compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());
        $category = new CategoryResource($category);
        return $this->apiSuccess(compact('category'));
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(null, 204);
    }
}