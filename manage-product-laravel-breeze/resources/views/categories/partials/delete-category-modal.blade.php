@foreach($categories as $category)
    <x-modal name="confirm-category-deletion-{{ $category->id }}" focusable>
        <form method="post" action="{{ route('categories.destroy', $category) }}" class="p-6">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete this category?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once this category is deleted, all of its resources and data will be permanently deleted.') }}
            </p>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Delete Category') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
@endforeach
