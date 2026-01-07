@extends('app')

@section('title', 'Create Category')
@section('page-title', 'Create New Category')
@section('page-subtitle', 'Add a new product category')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Card Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Category Details</h3>
                <p class="text-sm text-gray-500">Fill in the required information</p>
            </div>

            <!-- Form -->
            <form action="{{ route('category.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                <!-- Category Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Category Name *</label>
                    <input type="text" id="name" name="name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                        placeholder="e.g., Electronics">
                    <p class="mt-1 text-xs text-gray-500">Enter a descriptive name for the category</p>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                        placeholder="Describe the category..."></textarea>
                    <p class="mt-1 text-xs text-gray-500">Provide a detailed description of the category</p>
                </div>

                <div class="pt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-4">Status</label>
                    <div class="flex items-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="status" value="1" class="sr-only peer" checked>
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                            </div>
                            <span class="ml-3 text-sm text-gray-700">Active</span>
                        </label>
                        <p class="ml-4 text-xs text-gray-500">Inactive categories won't be shown on the website</p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="border-t border-gray-200 pt-6 flex justify-end space-x-3">
                    <a href="{{ route('category.index') }}"
                        class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition flex items-center space-x-2">
                        <span>Create Category</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
