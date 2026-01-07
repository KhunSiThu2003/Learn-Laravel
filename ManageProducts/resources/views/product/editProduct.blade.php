@extends('app')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')
@section('page-subtitle', 'Update product information')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Card Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Edit Product Information</h3>
                <p class="text-sm text-gray-500">Update the product details below</p>
            </div>

            <!-- Form -->
            <form action="{{ route('product.update', $product) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Product Image -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                            <div class="mt-1 flex flex-col items-center">
                                @if($product->image)
                                    <div class="mb-4">
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                             alt="{{ $product->name }}"
                                             class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                                    </div>
                                @endif
                                <div class="w-full">
                                    <input type="file" id="image" name="image"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                           accept="image/*">
                                </div>

                                @if($product->image)
                                <div class="mt-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="remove_image" id="remove_image"
                                               class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-600">Remove current image</span>
                                    </label>
                                </div>
                                @endif
                            </div>
                            @error('image')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            @if($product->image)
                                <p class="mt-1 text-xs text-gray-500">Current image. Upload a new one to replace or check "Remove current image" to delete.</p>
                            @else
                                <p class="mt-1 text-xs text-gray-500">Upload a product image (optional)</p>
                            @endif
                        </div>

                        <!-- Product Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                placeholder="e.g., iPhone 15 Pro Max">
                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                            <select id="category_id" name="category_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Image Preview -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image Preview</label>
                            <div id="image-preview" class="mt-1 w-full h-48 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         id="preview-image"
                                         class="w-full h-full object-contain"
                                         alt="Current product image">
                                @else
                                    <p class="text-gray-400" id="preview-text">No image selected</p>
                                @endif
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Preview of the selected image</p>
                        </div>

                        <!-- SKU -->
                        <div>
                            <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU (Stock Keeping Unit)</label>
                            <input type="text" id="sku" name="sku"
                                value="{{ old('sku', $product->sku) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                placeholder="e.g., PROD-001-2024">
                            @error('sku')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Weight -->
                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Weight (kg)</label>
                            <div class="relative">
                                <input type="number" id="weight" name="weight" step="0.01" min="0"
                                    value="{{ old('weight', $product->weight) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                    placeholder="0.00">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">kg</span>
                                </div>
                            </div>
                            @error('weight')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Price and Stock -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Price -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" id="price" name="price" step="0.01" min="0"
                                    value="{{ old('price', $product->price) }}"
                                    class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                    placeholder="0.00">
                            </div>
                            @error('price')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="compare_price" class="block text-sm font-medium text-gray-700 mb-2">Compare Price</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number" id="compare_price" name="compare_price" step="0.01" min="0"
                                    value="{{ old('compare_price', $product->compare_price) }}"
                                    class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                    placeholder="0.00">
                            </div>
                            @error('compare_price')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity *</label>
                        <input type="number" id="stock" name="stock" min="0"
                            value="{{ old('stock', $product->stock) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                            placeholder="e.g., 100">
                            @error('stock')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                    </div>
                </div>

                <!-- Dimensions -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-4">Dimensions (cm)</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="length" class="block text-sm font-medium text-gray-700 mb-2">Length</label>
                            <div class="relative">
                                <input type="number" id="length" name="length" step="0.1" min="0"
                                    value="{{ old('length', $product->length) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                    placeholder="0.0">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-xs text-gray-500">cm</span>
                                </div>
                            </div>
                            @error('length')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="width" class="block text-sm font-medium text-gray-700 mb-2">Width</label>
                            <div class="relative">
                                <input type="number" id="width" name="width" step="0.1" min="0"
                                    value="{{ old('width', $product->width) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                    placeholder="0.0">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-xs text-gray-500">cm</span>
                                </div>
                            </div>
                            @error('width')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="height" class="block text-sm font-medium text-gray-700 mb-2">Height</label>
                            <div class="relative">
                                <input type="number" id="height" name="height" step="0.1" min="0"
                                    value="{{ old('height', $product->height) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                    placeholder="0.0">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-xs text-gray-500">cm</span>
                                </div>
                            </div>
                            @error('height')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                        placeholder="Describe the product features, specifications, and benefits...">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-4">Status *</label>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="radio" id="status_active" name="status" value="active"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                   {{ old('status', $product->status) === 'active' ? 'checked' : '' }}>
                            <label for="status_active" class="ml-3 text-sm text-gray-700">
                                <span class="font-medium">Active</span>
                                <p class="text-gray-500">Product is visible on the store</p>
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="status_draft" name="status" value="draft"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                   {{ old('status', $product->status) === 'draft' ? 'checked' : '' }}>
                            <label for="status_draft" class="ml-3 text-sm text-gray-700">
                                <span class="font-medium">Draft</span>
                                <p class="text-gray-500">Product is hidden from the store</p>
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="status_inactive" name="status" value="inactive"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                   {{ old('status', $product->status) === 'inactive' ? 'checked' : '' }}>
                            <label for="status_inactive" class="ml-3 text-sm text-gray-700">
                                <span class="font-medium">Inactive</span>
                                <p class="text-gray-500">Product is permanently hidden</p>
                            </label>
                        </div>
                    </div>
                    @error('status')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Metadata -->
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Created</p>
                            <p class="text-sm text-gray-900">{{ $product->created_at->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</p>
                            <p class="text-sm text-gray-900">{{ $product->updated_at->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Product ID</p>
                            <p class="text-sm text-gray-900">{{ $product->id }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="border-t border-gray-200 pt-6 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">
                            Last modified: {{ $product->updated_at->diffForHumans() }}
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('product.index') }}"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Save Changes</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Image preview functionality for edit form
        document.getElementById('image').addEventListener('change', function(e) {
            const preview = document.getElementById('image-preview');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Remove text if exists
                    const previewText = document.getElementById('preview-text');
                    if (previewText) {
                        previewText.remove();
                    }

                    // Update or create image preview
                    let img = document.getElementById('preview-image');
                    if (!img) {
                        img = document.createElement('img');
                        img.id = 'preview-image';
                        img.className = 'w-full h-full object-contain';
                        preview.appendChild(img);
                    }
                    img.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // Handle remove image checkbox
        document.getElementById('remove_image')?.addEventListener('change', function(e) {
            const imageInput = document.getElementById('image');
            const preview = document.getElementById('image-preview');

            if (this.checked) {
                // Clear file input
                imageInput.value = '';

                // Update preview
                const img = document.getElementById('preview-image');
                if (img) {
                    img.remove();
                }
                if (!document.getElementById('preview-text')) {
                    const text = document.createElement('p');
                    text.id = 'preview-text';
                    text.className = 'text-gray-400';
                    text.textContent = 'Image will be removed';
                    preview.appendChild(text);
                }
            }
        });
    </script>
@endsection
