@foreach($products as $product)
@php
    // Pass categories to each modal instance
    $categories = $categories ?? \App\Models\Category::all();
@endphp
<x-modal name="edit-product-{{ $product->id }}" :show="$errors->any() && old('product_id') == $product->id" focusable>
    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data" class="p-6">
        @csrf
        @method('PUT')
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Edit Product') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Update product information.') }}
            </p>
        </header>

        <div class="mt-6 space-y-6 max-h-[70vh] overflow-y-auto pr-2">
            <!-- Current Images -->
            <div>
                <x-input-label :value="__('Current Images')" />
                <div class="mt-2 grid grid-cols-3 gap-2">
                    @foreach($product->images as $image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                 alt="Product Image" 
                                 class="w-full h-24 object-cover rounded-md">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-md flex items-center justify-center">
                                <label class="flex items-center space-x-1 text-white text-sm cursor-pointer">
                                    <input type="checkbox" 
                                           name="remove_images[]" 
                                           value="{{ $image->id }}"
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span>Remove</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- New Image Upload -->
            <div>
                <x-input-label for="new_images_{{ $product->id }}" :value="__('Add New Images')" />
                <div class="mt-1">
                    <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="new_images_{{ $product->id }}" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>{{ __('Upload images') }}</span>
                                    <input id="new_images_{{ $product->id }}" name="new_images[]" type="file" class="sr-only" accept="image/*" multiple>
                                </label>
                                <p class="pl-1">{{ __('or drag and drop') }}</p>
                            </div>
                            <p class="text-xs text-gray-500">{{ __('PNG, JPG, GIF up to 2MB each') }}</p>
                        </div>
                    </div>
                </div>
                <div id="new-image-preview-{{ $product->id }}" class="mt-2 grid grid-cols-3 gap-2"></div>
                <x-input-error :messages="$errors->get('new_images')" class="mt-2" />
                <x-input-error :messages="$errors->get('new_images.*')" class="mt-2" />
            </div>

            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Name -->
                <div>
                    <x-input-label for="edit_name_{{ $product->id }}" :value="__('Product Name *')" />
                    <x-text-input id="edit_name_{{ $product->id }}" name="name" type="text" class="mt-1 block w-full" 
                        value="{{ old('name', $product->name) }}" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Category -->
                <div>
                    <x-input-label for="edit_category_id_{{ $product->id }}" :value="__('Category *')" />
                    <select id="edit_category_id_{{ $product->id }}" name="category_id" required
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">{{ __('Select a category') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                </div>
            </div>

            <!-- Pricing -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="edit_price_{{ $product->id }}" :value="__('Price *')" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <x-text-input id="edit_price_{{ $product->id }}" name="price" type="number" step="0.01" min="0" 
                            class="pl-7 block w-full" value="{{ old('price', $product->price) }}" required />
                    </div>
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="edit_compare_price_{{ $product->id }}" :value="__('Compare Price')" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <x-text-input id="edit_compare_price_{{ $product->id }}" name="compare_price" type="number" step="0.01" min="0" 
                            class="pl-7 block w-full" value="{{ old('compare_price', $product->compare_price) }}" />
                    </div>
                    <x-input-error :messages="$errors->get('compare_price')" class="mt-2" />
                </div>
            </div>

            <!-- Stock and SKU -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="edit_stock_{{ $product->id }}" :value="__('Stock Quantity *')" />
                    <x-text-input id="edit_stock_{{ $product->id }}" name="stock" type="number" min="0" 
                        class="mt-1 block w-full" value="{{ old('stock', $product->stock) }}" required />
                    <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="edit_sku_{{ $product->id }}" :value="__('SKU (Stock Keeping Unit)')" />
                    <x-text-input id="edit_sku_{{ $product->id }}" name="sku" type="text" 
                        class="mt-1 block w-full" value="{{ old('sku', $product->sku) }}" />
                    <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                </div>
            </div>

            <!-- Weight -->
            <div>
                <x-input-label for="edit_weight_{{ $product->id }}" :value="__('Weight (kg)')" />
                <div class="mt-1 relative rounded-md shadow-sm">
                    <x-text-input id="edit_weight_{{ $product->id }}" name="weight" type="number" step="0.01" min="0" 
                        class="block w-full pr-12" value="{{ old('weight', $product->weight) }}" />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">kg</span>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('weight')" class="mt-2" />
            </div>

            <!-- Dimensions -->
            <div>
                <x-input-label :value="__('Dimensions (cm)')" />
                <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="edit_length_{{ $product->id }}" :value="__('Length')" class="sr-only" />
                        <div class="relative rounded-md shadow-sm">
                            <x-text-input id="edit_length_{{ $product->id }}" name="length" type="number" step="0.1" min="0" 
                                class="block w-full pr-12" value="{{ old('length', $product->length) }}" />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">cm</span>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('length')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_width_{{ $product->id }}" :value="__('Width')" class="sr-only" />
                        <div class="relative rounded-md shadow-sm">
                            <x-text-input id="edit_width_{{ $product->id }}" name="width" type="number" step="0.1" min="0" 
                                class="block w-full pr-12" value="{{ old('width', $product->width) }}" />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">cm</span>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('width')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_height_{{ $product->id }}" :value="__('Height')" class="sr-only" />
                        <div class="relative rounded-md shadow-sm">
                            <x-text-input id="edit_height_{{ $product->id }}" name="height" type="number" step="0.1" min="0" 
                                class="block w-full pr-12" value="{{ old('height', $product->height) }}" />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">cm</span>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('height')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <x-input-label for="edit_description_{{ $product->id }}" :value="__('Description')" />
                <textarea id="edit_description_{{ $product->id }}" name="description" rows="4"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!-- Status -->
            <div>
                <x-input-label :value="__('Status *')" />
                <div class="mt-2 space-y-2">
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="active" 
                            {{ old('status', $product->status) == 'active' ? 'checked' : '' }}
                            class="border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" required>
                        <span class="ml-2 text-sm text-gray-600">{{ __('Active') }}</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="draft" 
                            {{ old('status', $product->status) == 'draft' ? 'checked' : '' }}
                            class="border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Draft') }}</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="inactive" 
                            {{ old('status', $product->status) == 'inactive' ? 'checked' : '' }}
                            class="border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Inactive') }}</span>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button>
                {{ __('Update Product') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // New image preview functionality for edit modal
            const newImagesInput = document.getElementById('new_images_{{ $product->id }}');
            if (newImagesInput) {
                newImagesInput.addEventListener('change', function(e) {
                    const preview = document.getElementById('new-image-preview-{{ $product->id }}');
                    const files = e.target.files;
                    
                    // Clear existing previews for new images
                    preview.innerHTML = '';
                    
                    if (files.length > 0) {
                        Array.from(files).forEach((file, index) => {
                            if (file.type.startsWith('image/')) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const imgContainer = document.createElement('div');
                                    imgContainer.className = 'relative';
                                    
                                    const img = document.createElement('img');
                                    img.src = e.target.result;
                                    img.className = 'w-full h-24 object-cover rounded-md';
                                    img.alt = 'New Preview ' + (index + 1);
                                    
                                    const removeBtn = document.createElement('button');
                                    removeBtn.type = 'button';
                                    removeBtn.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600';
                                    removeBtn.innerHTML = '×';
                                    removeBtn.onclick = function() {
                                        imgContainer.remove();
                                    };
                                    
                                    imgContainer.appendChild(img);
                                    imgContainer.appendChild(removeBtn);
                                    preview.appendChild(imgContainer);
                                }
                                reader.readAsDataURL(file);
                            }
                        });
                    }
                });
                
                // Allow drag and drop for new images
                const dropArea = document.querySelector('input[name="new_images[]"]').parentElement.parentElement;
                
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, preventDefaults, false);
                });
                
                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                
                ['dragenter', 'dragover'].forEach(eventName => {
                    dropArea.addEventListener(eventName, highlight, false);
                });
                
                ['dragleave', 'drop'].forEach(eventName => {
                    dropArea.addEventListener(eventName, unhighlight, false);
                });
                
                function highlight() {
                    dropArea.parentElement.classList.add('border-indigo-500');
                }
                
                function unhighlight() {
                    dropArea.parentElement.classList.remove('border-indigo-500');
                }
                
                dropArea.addEventListener('drop', handleDrop, false);
                
                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    
                    if (files.length > 0) {
                        document.getElementById('new_images_{{ $product->id }}').files = files;
                        document.getElementById('new_images_{{ $product->id }}').dispatchEvent(new Event('change'));
                    }
                }
            }

            // When edit modal opens, show current data
            document.addEventListener('modal-opened', function(event) {
                if (event.detail.modalName === 'edit-product-{{ $product->id }}') {
                    console.log('Edit modal for product {{ $product->id }} opened');
                }
            });
        });
    </script>
</x-modal>
@endforeach