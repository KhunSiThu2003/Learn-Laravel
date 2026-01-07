<x-app-layout>

    <div>
        @include('categories.partials.categories')
    </div>

    <!-- Create Category Modal -->
    @include('categories.partials.create-category-modal')

    <!-- Edit Modals for each category -->
    @include('categories.partials.edit-category-modal')

    <!-- Delete Modals for each category -->
    @include('categories.partials.delete-category-modal')

</x-app-layout>