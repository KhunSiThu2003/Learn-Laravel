<x-app-layout>

    <div>
        @include('products.partials.products')
    </div>

    <!-- Create Product Modal -->
    @include('products.partials.create-product-modal')

    <!-- Edit Modals for each product -->
     @include('products.partials.edit-product-modal')

    <!-- Delete Modals for each product -->
    @include('products.partials.delete-product-modal')

    <!-- Product Details Modals for each product -->
    @include('products.partials.product-details-modal')

</x-app-layout>
