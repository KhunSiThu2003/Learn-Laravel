<x-modal name="create-category" :show="$errors->any() && !old('category_id')" focusable>
    <form method="POST" action="{{ route('categories.store') }}" class="p-6">
        @csrf
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Create New Category') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Create a new category for your products.') }}
            </p>
        </header>

        <div class="mt-6 space-y-6">
            <div>
                <x-input-label for="create_name" :value="__('Category Name *')" />
                <x-text-input id="create_name" name="name" type="text" class="mt-1 block w-full" 
                    value="{{ old('name') }}" required autocomplete="category-name" />
                @if(!old('category_id'))
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                @endif
            </div>

            <div>
                <x-input-label for="create_description" :value="__('Description')" />
                <textarea id="create_description" name="description" rows="3"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                @if(!old('category_id'))
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                @endif
            </div>

            <div class="space-y-4">
                <x-input-label :value="__('Status')" />
                <div class="space-y-2">
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="1" 
                            {{ old('status', '1') == '1' ? 'checked' : '' }}
                            class="border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Active') }}</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="status" value="0" 
                            {{ old('status') == '0' ? 'checked' : '' }}
                            class="border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Inactive') }}</span>
                    </label>
                </div>
                @if(!old('category_id'))
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                @endif
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button>
                {{ __('Create Category') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>