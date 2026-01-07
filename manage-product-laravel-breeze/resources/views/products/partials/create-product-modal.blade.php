<x-modal name="create-product" :show="$errors->any()" focusable>
    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="p-6">
        @csrf
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Create New Product') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Add a new product to your inventory.') }}
            </p>
        </header>

        <div class="mt-6 space-y-6 max-h-[70vh] overflow-y-auto pr-2">
            <!-- Product Image Upload -->
            <div>
                <x-input-label for="images" :value="__('Product Images')" />
                <div class="mt-1">
                    <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                viewBox="0 0 48 48">
                                <path
                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="images"
                                    class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>{{ __('Upload images') }}</span>
                                    <input id="images" name="images[]" type="file" class="sr-only"
                                        accept="image/*" multiple>
                                </label>
                                <p class="pl-1">{{ __('or drag and drop') }}</p>
                            </div>
                            <p class="text-xs text-gray-500">{{ __('PNG, JPG, GIF up to 2MB each') }}</p>
                        </div>
                    </div>
                </div>
                <div id="image-preview" class="mt-2 grid grid-cols-3 gap-2"></div>
                <x-input-error :messages="$errors->get('images')" class="mt-2" />
                <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
            </div>

            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Name -->
                <div>
                    <x-input-label for="name" :value="__('Product Name *')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                        value="{{ old('name') }}" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Category -->
                <div>
                    <x-input-label for="category_id" :value="__('Category *')" />
                    <select id="category_id" name="category_id" required
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">{{ __('Select a category') }}</option>
                        @foreach ($categories as $category)
                            @if ($category->status == 1)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                </div>
            </div>

            <!-- Pricing -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="price" :value="__('Price *')" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <x-text-input id="price" name="price" type="number" step="0.01" min="0"
                            class="pl-7 block w-full" value="{{ old('price') }}" required />
                    </div>
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="compare_price" :value="__('Compare Price')" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <x-text-input id="compare_price" name="compare_price" type="number" step="0.01"
                            min="0" class="pl-7 block w-full" value="{{ old('compare_price') }}" />
                    </div>
                    <x-input-error :messages="$errors->get('compare_price')" class="mt-2" />
                </div>
            </div>

            <!-- Stock and SKU -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="stock" :value="__('Stock Quantity *')" />
                    <x-text-input id="stock" name="stock" type="number" min="0" class="mt-1 block w-full"
                        value="{{ old('stock') }}" required />
                    <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="sku" :value="__('SKU (Stock Keeping Unit)')" />
                    <x-text-input id="sku" name="sku" type="text" class="mt-1 block w-full"
                        value="{{ old('sku') }}" />
                    <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                </div>
            </div>

            <!-- Weight -->
            <div>
                <x-input-label for="weight" :value="__('Weight (kg)')" />
                <div class="mt-1 relative rounded-md shadow-sm">
                    <x-text-input id="weight" name="weight" type="number" step="0.01" min="0"
                        class="block w-full pr-12" value="{{ old('weight') }}" />
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
                        <x-input-label for="length" :value="__('Length')" class="sr-only" />
                        <div class="relative rounded-md shadow-sm">
                            <x-text-input id="length" name="length" type="number" step="0.1"
                                min="0" class="block w-full pr-12" value="{{ old('length') }}" />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">cm</span>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('length')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="width" :value="__('Width')" class="sr-only" />
                        <div class="relative rounded-md shadow-sm">
                            <x-text-input id="width" name="width" type="number" step="0.1"
                                min="0" class="block w-full pr-12" value="{{ old('width') }}" />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 text-sm">cm</span>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('width')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="height" :value="__('Height')" class="sr-only" />
                        <div class="relative rounded-md shadow-sm">
                            <x-text-input id="height" name="height" type="number" step="0.1"
                                min="0" class="block w-full pr-12" value="{{ old('height') }}" />
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
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" name="description" rows="4"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!-- Status -->
            <div>
                <x-input-label :value="__('Status *')" />
                <div class="mt-2 space-y-2">
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="active"
                            {{ old('status', 'draft') == 'active' ? 'checked' : '' }}
                            class="border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" required>
                        <span class="ml-2 text-sm text-gray-600">{{ __('Active') }}</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="draft"
                            {{ old('status', 'draft') == 'draft' ? 'checked' : '' }}
                            class="border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Draft') }}</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="inactive"
                            {{ old('status', 'draft') == 'inactive' ? 'checked' : '' }}
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
                {{ __('Create Product') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        // Image preview functionality for multiple images
        document.addEventListener('DOMContentLoaded', function() {
            const imagesInput = document.getElementById('images');
            if (imagesInput) {
                imagesInput.addEventListener('change', function(e) {
                    const preview = document.getElementById('image-preview');
                    const files = e.target.files;

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
                                    img.alt = 'Preview ' + (index + 1);

                                    const removeBtn = document.createElement('button');
                                    removeBtn.type = 'button';
                                    removeBtn.className =
                                        'absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600';
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

                // Allow drag and drop
                const dropArea = document.querySelector('input[name="images[]"]').parentElement.parentElement;

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
                        document.getElementById('images').files = files;
                        document.getElementById('images').dispatchEvent(new Event('change'));
                    }
                }
            }
        });
    </script>
</x-modal>
