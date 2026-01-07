@extends('app')

@section('title', $product->name)
@section('page-title', 'Product Details')
@section('page-subtitle', 'View complete product information')

@section('content')
    <div class="space-y-6">
        <!-- Product Details Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Card Header with Actions -->
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">{{ $product->name }}</h1>
                    <div class="flex items-center space-x-3 mt-2">
                        @if($product->status === 'active')
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Active</span>
                        @elseif($product->status === 'inactive')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">Inactive</span>
                        @else
                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">Draft</span>
                        @endif
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </span>
                        <span class="text-sm text-gray-500">ID: {{ $product->id }}</span>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('product.edit', $product) }}"
                       class="px-4 py-2 border border-blue-600 text-blue-600 font-medium rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit Product</span>
                    </a>

                    <a href="{{ route('product.index') }}"
                       class="px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Back to Products</span>
                    </a>
                </div>
            </div>

            <!-- Product Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Product Info -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Product Image -->
                        @if($product->image)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Image</h3>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full max-w-md mx-auto object-cover rounded-lg">
                            </div>
                        </div>
                        @endif

                        <!-- Description -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Description</h3>
                            <div class="prose max-w-none">
                                @if($product->description)
                                    <p class="text-gray-700 whitespace-pre-line">{{ $product->description }}</p>
                                @else
                                    <p class="text-gray-500 italic">No description provided.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Pricing & Stock -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Pricing Card -->
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Pricing</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Current Price</span>
                                        <span class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                    </div>
                                    @if($product->compare_price)
                                        <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                                            <span class="text-gray-600">Compare Price</span>
                                            <span class="text-lg text-gray-500 line-through">${{ number_format($product->compare_price, 2) }}</span>
                                        </div>
                                        <div class="pt-2 border-t border-gray-200">
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-600">Savings</span>
                                                <span class="text-lg font-medium text-green-600">
                                                    {{ number_format((($product->compare_price - $product->price) / $product->compare_price) * 100, 1) }}%
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Stock Card -->
                            <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Inventory</h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Stock Quantity</span>
                                        <div class="flex items-center space-x-2">
                                            @if($product->stock > 10)
                                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                                    {{ $product->stock }} units
                                                </span>
                                            @elseif($product->stock > 0)
                                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                                    Low stock ({{ $product->stock }})
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                                    Out of stock
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    @if($product->sku)
                                    <div class="flex justify-between items-center pt-2 border-t border-gray-200">
                                        <span class="text-gray-600">SKU</span>
                                        <span class="font-mono text-sm bg-white px-3 py-1 rounded border border-gray-300">
                                            {{ $product->sku }}
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Specifications -->
                        @if($product->weight || $product->length || $product->width || $product->height)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Specifications</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @if($product->weight)
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <p class="text-sm font-medium text-gray-500 mb-1">Weight</p>
                                    <p class="text-lg font-semibold text-gray-800">{{ number_format($product->weight, 2) }} kg</p>
                                </div>
                                @endif

                                @if($product->length)
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <p class="text-sm font-medium text-gray-500 mb-1">Length</p>
                                    <p class="text-lg font-semibold text-gray-800">{{ number_format($product->length, 1) }} cm</p>
                                </div>
                                @endif

                                @if($product->width)
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <p class="text-sm font-medium text-gray-500 mb-1">Width</p>
                                    <p class="text-lg font-semibold text-gray-800">{{ number_format($product->width, 1) }} cm</p>
                                </div>
                                @endif

                                @if($product->height)
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <p class="text-sm font-medium text-gray-500 mb-1">Height</p>
                                    <p class="text-lg font-semibold text-gray-800">{{ number_format($product->height, 1) }} cm</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Right Column - Metadata & Actions -->
                    <div class="space-y-6">
                        <!-- Product Status Card -->
                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                                <h4 class="text-sm font-medium text-gray-800">Product Status</h4>
                            </div>
                            <div class="p-4">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Visibility</span>
                                        @if($product->status === 'active')
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Visible</span>
                                        @else
                                            <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">Hidden</span>
                                        @endif
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Last Updated</span>
                                        <span class="text-sm text-gray-900">{{ $product->updated_at->format('M d, Y') }}</span>
                                    </div>

                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Created</span>
                                        <span class="text-sm text-gray-900">{{ $product->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>

                                <!-- Quick Status Actions -->
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <form action="{{ route('product.destroy', $product) }}" method="POST" class="space-y-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this product? This action cannot be undone.')"
                                                class="w-full px-4 py-2 bg-red-50 text-red-700 border border-red-200 rounded-lg hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition flex items-center justify-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            <span>Delete Product</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Category Information -->
                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                                <h4 class="text-sm font-medium text-gray-800">Category</h4>
                            </div>
                            <div class="p-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                        <p class="text-sm text-gray-500">Product Category</p>
                                    </div>
                                </div>

                                @if($product->category && $product->category->description)
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <p class="text-sm text-gray-600">{{ $product->category->description }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Additional Actions -->
                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                                <h4 class="text-sm font-medium text-gray-800">Quick Actions</h4>
                            </div>
                            <div class="p-4 space-y-3">
                                <a href="{{ route('product.edit', $product) }}"
                                   class="w-full px-4 py-3 bg-blue-50 text-blue-700 border border-blue-200 rounded-lg hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    <span>Edit Product Details</span>
                                </a>

                                @if($product->image)
                                <a href="{{ asset('storage/' . $product->image) }}" download
                                   target="_blank"
                                   class="w-full px-4 py-3 bg-green-50 text-green-700 border border-green-200 rounded-lg hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    <span>Download Image</span>
                                </a>
                                @endif

                                <button type="button"
                                        onclick="navigator.clipboard.writeText('{{ $product->id }}'); alert('Product ID copied to clipboard!');"
                                        class="w-full px-4 py-3 bg-gray-50 text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Copy Product ID</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
                <p class="text-sm text-gray-500">Product updates and changes</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800">Product was updated</p>
                            <p class="text-xs text-gray-500">{{ $product->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-800">Product was created</p>
                            <p class="text-xs text-gray-500">{{ $product->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

