@foreach($products as $product)
<x-modal name="product-details-{{ $product->id }}" focusable>
    <div class="p-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Product Details') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Complete information about the product') }}
            </p>
        </header>

        <div class="mt-6 space-y-6 max-h-[70vh] overflow-y-auto pr-2">
            <!-- Product Images Carousel -->
            <div>
                <x-input-label :value="__('Product Images')" />
                @if($product->images->count() > 0)
                    <div class="mt-2">
                        <!-- Main Image -->
                        <div id="main-image-{{ $product->id }}" class="mb-4">
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-64 object-cover rounded-lg shadow-md">
                        </div>
                        
                        <!-- Thumbnail Images -->
                        @if($product->images->count() > 1)
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($product->images as $image)
                                    <button type="button" 
                                            onclick="changeMainImage('{{ $product->id }}', '{{ asset('storage/' . $image->image_path) }}')"
                                            class="focus:outline-none">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             alt="Thumbnail" 
                                             class="w-full h-16 object-cover rounded-md hover:opacity-80 transition-opacity border-2 border-transparent hover:border-indigo-500">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <div class="mt-2 flex justify-center items-center h-48 bg-gray-100 rounded-lg">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">No images available</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Name -->
                <div>
                    <x-input-label :value="__('Product Name')" />
                    <p class="mt-1 text-sm text-gray-900 font-medium">{{ $product->name }}</p>
                </div>

                <!-- Category -->
                <div>
                    <x-input-label :value="__('Category')" />
                    <div class="mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div>
                <x-input-label :value="__('Status')" />
                <div class="mt-1">
                    @if ($product->status === 'active')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Active
                        </span>
                    @elseif($product->status === 'draft')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                            </svg>
                            Draft
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            Inactive
                        </span>
                    @endif
                </div>
            </div>

            <!-- Pricing -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label :value="__('Price')" />
                    <div class="mt-1">
                        <span class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                        @if($product->compare_price)
                            <span class="ml-2 text-sm text-gray-500 line-through">${{ number_format($product->compare_price, 2) }}</span>
                            @php
                                $discountPercentage = round((($product->compare_price - $product->price) / $product->compare_price) * 100);
                            @endphp
                            <span class="ml-2 px-2 py-1 text-xs font-bold bg-red-100 text-red-800 rounded">
                                Save {{ $discountPercentage }}%
                            </span>
                        @endif
                    </div>
                </div>

                <div>
                    <x-input-label :value="__('Stock Quantity')" />
                    <div class="mt-1">
                        @if($product->stock > 10)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                {{ $product->stock }} in stock
                            </span>
                        @elseif($product->stock > 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                {{ $product->stock }} in stock (Low)
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                Out of stock
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- SKU -->
            <div>
                <x-input-label :value="__('SKU (Stock Keeping Unit)')" />
                <p class="mt-1 text-sm text-gray-900 font-mono">{{ $product->sku ?? 'N/A' }}</p>
            </div>

            <!-- Physical Properties -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Weight -->
                <div>
                    <x-input-label :value="__('Weight')" />
                    <p class="mt-1 text-sm text-gray-900">{{ $product->weight ? number_format($product->weight, 2) . ' kg' : 'N/A' }}</p>
                </div>

                <!-- Dimensions -->
                <div>
                    <x-input-label :value="__('Dimensions')" />
                    @if($product->length && $product->width && $product->height)
                        <p class="mt-1 text-sm text-gray-900">
                            {{ number_format($product->length, 1) }} × {{ number_format($product->width, 1) }} × {{ number_format($product->height, 1) }} cm
                        </p>
                    @else
                        <p class="mt-1 text-sm text-gray-900">N/A</p>
                    @endif
                </div>
            </div>

            <!-- Description -->
            @if($product->description)
                <div>
                    <x-input-label :value="__('Description')" />
                    <div class="mt-1 p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $product->description }}</p>
                    </div>
                </div>
            @endif

            <!-- Created/Updated Information -->
            <div class="pt-4 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-gray-500">
                    <div>
                        <span class="font-medium">Created:</span> {{ $product->created_at->format('M d, Y \a\t h:i A') }}
                    </div>
                    <div>
                        <span class="font-medium">Last Updated:</span> {{ $product->updated_at->format('M d, Y \a\t h:i A') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Close') }}
            </x-secondary-button>
        </div>
    </div>

    <script>
        // Function to change main image when clicking on thumbnails
        function changeMainImage(productId, imageUrl) {
            const mainImage = document.getElementById('main-image-' + productId);
            if (mainImage) {
                mainImage.innerHTML = `<img src="${imageUrl}" alt="Product Image" class="w-full h-64 object-cover rounded-lg shadow-md">`;
            }
        }

        // Add keyboard navigation for image carousel
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('keydown', function(e) {
                const activeModal = document.querySelector('[x-show*="product-details"]');
                if (activeModal && activeModal.style.display !== 'none') {
                    // Add keyboard shortcuts if needed
                }
            });
        });
    </script>
</x-modal>
@endforeach