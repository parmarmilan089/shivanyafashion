@extends('admin.layout.page')
@section('contect')
    <!-- other blade content -->
    <script>
        window.inventoryProps = {
            categories: @json($categories),
            subcategories: @json($subcategories),
            subsubcategories: @json($subsubcategories),
            colors: @json($colors),
            sizes: @json($sizes),
        };

    </script>

    <div id="inventory-create">
        <inventory-create v-bind:categories="window.inventoryProps.categories"
            v-bind:subcategories="window.inventoryProps.subcategories"
            v-bind:subsubcategories="window.inventoryProps.subsubcategories" v-bind:colors="window.inventoryProps.colors"
            v-bind:sizes="window.inventoryProps.sizes"></inventory-create>
    </div>


@endsection