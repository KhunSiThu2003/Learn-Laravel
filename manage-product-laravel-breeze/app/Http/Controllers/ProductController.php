<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $categoryId = $request->get('category');
        $status = $request->get('status');

        $products = Product::with(['category', 'images'])
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->withQueryString();

        $totalProduct = Product::count();
        $totalActiveProducts = Product::where('status', 'active')->count();
        $totalDraftProducts = Product::where('status', 'draft')->count();
        $totalInactiveProducts = Product::where('status', 'inactive')->count();

        $categories = Category::all();

        return view('products.index', compact(
            'products',
            'search',
            'totalProduct',
            'totalActiveProducts',
            'totalDraftProducts',
            'totalInactiveProducts',
            'categories'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $product = Product::create($request->validated());

            if ($request->hasFile('images')) {
                $imageCount = 1;

                foreach ($request->file('images') as $image) {
                    $extension = $image->getClientOriginalExtension();

                    $customName = strtolower(str_replace(' ', '_', $product->name))
                        . '_' . time()
                        . '_' . $imageCount
                        . '.' . $extension;

                    $path = $image->storeAs('product_images', $customName, 'public');

                    $product->images()->create([
                        'image_path' => $path,
                    ]);

                    $imageCount++;
                }
            }

            DB::commit();

            return redirect()->route('products.index')
                ->with('success', 'Product created successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('products.index')
                ->with('error', 'Failed to create product. Error: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $product->update($request->validated());

            // Handle image deletion
            if ($request->has('remove_images') && is_array($request->remove_images)) {
                $imagesToDelete = $product->images()
                    ->whereIn('id', $request->remove_images)
                    ->get();

                foreach ($imagesToDelete as $image) {
                    if (Storage::disk('public')->exists($image->image_path)) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                    $image->delete();
                }
            }

            // Handle new image uploads
            if ($request->hasFile('new_images')) {
                $imageCount = $product->images()->count() + 1;

                foreach ($request->file('new_images') as $image) {
                    $extension = $image->getClientOriginalExtension();

                    $customName = strtolower(str_replace(' ', '_', $product->name))
                        . '_' . time()
                        . '_' . $imageCount
                        . '.' . $extension;

                    $path = $image->storeAs('product_images', $customName, 'public');

                    $product->images()->create([
                        'image_path' => $path,
                    ]);

                    $imageCount++;
                }
            }

            DB::commit();

            return redirect()->route('products.index')
                ->with('success', 'Product updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('products.index')
                ->with('error', 'Failed to update product. Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            DB::beginTransaction();

            foreach ($product->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }

            $product->delete();

            DB::commit();

            return redirect()->route('products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->route('products.index')
                ->with('error', 'Failed to delete product. Please try again.');
        }
    }

    // Empty methods
    public function create() {}
    public function show(Product $product) {}
    public function edit(Product $product) {}
}
