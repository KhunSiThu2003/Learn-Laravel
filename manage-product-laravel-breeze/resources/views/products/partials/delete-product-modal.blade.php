@foreach ($products as $product)
    <x-modal name="confirm-product-deletion-{{ $product->id }}" focusable>
        <form method="POST" action="{{ route('products.destroy', $product) }}" class="p-6">
            @csrf
            @method('DELETE')

            <header>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Delete Product') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ __('Are you sure you want to delete this product?') }}
                </p>
            </header>

            <div class="mt-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-start space-x-4">
                        @if ($product->images->first())
                            <div class="flex-shrink-0">
                                <img class="h-16 w-16 rounded-lg object-cover"
                                    src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                    alt="{{ $product->name }}">
                            </div>
                        @endif
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Category: {{ $product->category->name ?? 'Uncategorized' }}
                            </p>
                            <p class="mt-1 text-sm text-gray-600">
                                Price: ${{ number_format($product->price, 2) }}
                            </p>
                            <p class="mt-1 text-sm text-gray-600">
                                Stock: {{ $product->stock }} units
                            </p>
                        </div>
                    </div>
                </div>

                <p class="mt-4 text-sm text-gray-600">
                    {{ __('This action cannot be undone. All product data and images will be permanently deleted.') }}
                </p>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button type="submit">
                    {{ __('Delete Product') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
@endforeach
