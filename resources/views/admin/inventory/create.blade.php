@extends('admin.layout.page')
@section('content')
    <script>
        window.inventoryProps = {
            categories: @json($categories ?? []),
            subcategories: @json($subcategories ?? []),
            subsubcategories: @json($subsubcategories ?? []),
            colors: @json($colors ?? []),
            sizes: @json($sizes ?? []),
        };
    </script>

    <div id="inventory-create">
        <inventory-create 
            :categories="window.inventoryProps.categories"
            :subcategories="window.inventoryProps.subcategories"
            :subsubcategories="window.inventoryProps.subsubcategories" 
            :colors="window.inventoryProps.colors"
            :sizes="window.inventoryProps.sizes">
        </inventory-create>
    </div>
@endsection