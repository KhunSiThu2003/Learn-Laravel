<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'images'])->get();

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
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

                    // Store in 'public/product_images' folder
                    $path = $image->storeAs('product_images', $customName, 'public');

                    $product->images()->create([
                        'image_path' => $path,
                    ]);

                    $imageCount++;
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => $product->load('images', 'category')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'images']);

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
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
                    // Delete file from storage
                    if (Storage::disk('public')->exists($image->image_path)) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                    // Delete record from database
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

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => $product->fresh()->load(['category', 'images'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

}
