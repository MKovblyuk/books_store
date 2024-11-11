<?php

namespace App\Http\Controllers\Api\V1\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Books\StoreCategoryRequest;
use App\Http\Requests\V1\Books\UpdateCategoryRequest;
use App\Http\Resources\V1\Books\CategoryCollection;
use App\Http\Resources\V1\Books\CategoryResource;
use App\Models\V1\Books\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show', 'getChildren']]);
    }

    public function index()
    {
        $categories = Category::whereIsRoot()->first()->children()->get();
        return new CategoryCollection($categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->authorize('create', Category::class);
        return $this->storeForParent($request, Category::whereIsRoot()->first());
    }

    public function storeForParent(StoreCategoryRequest $request, Category $parentCategory)
    {
        $this->authorize('createForParent', Category::class);
        Category::create($request->validated(), $parentCategory);

        return response()->json(['message' => 'Category successfully created'], 201);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);
        $category->update($request->validated());

        return response()->json(['message' => 'Category successfully updated'], 200);
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        return $category->delete()
            ? response()->noContent()
            : response()->json(['message' => 'Category not deleted'], 500);
    }

    public function getChildren(Category $parentCategory)
    {
        return new CategoryCollection($parentCategory->children()->get());
    }
}
