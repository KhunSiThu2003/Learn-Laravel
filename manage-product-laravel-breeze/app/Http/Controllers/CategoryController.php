<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Exception;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $categories = Category::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $totalCategories = Category::count();
        $activeCategories = Category::where('status', true)->count();
        $inactiveCategories = Category::where('status', false)->count();

        return view('categories.index', compact('categories', 'search', 'totalCategories', 'activeCategories', 'inactiveCategories'));
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        
        Category::create($request->validated());
        
        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        
        $category->update($request->validated());
        
        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        try {
            $category->delete();
            
            return redirect()->route('categories.index')
                ->with('success', 'Category deleted successfully.');
                
        } catch (Exception $e) {
            return redirect()->route('categories.index')
                ->with('error', 'Failed to delete category. Please try again.');
        }
    }

    // Empty methods
    public function create() {}
    public function show(Category $category) {}
    public function edit(Category $category) {}
}