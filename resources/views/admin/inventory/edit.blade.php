@extends('admin.layout.page')
@section('content')
<script>
    window.inventoryEditProps = {
        inventory: @json($inventory),
        categories: @json($categories ?? []),
        subcategories: @json($subcategories ?? []),
        subsubcategories: @json($subsubcategories ?? []),
        colors: @json($colors ?? []),
        sizes: @json($sizes ?? []),
        variants: @json($variants ?? []),
    };
</script>

<div id="inventory-edit">
    <inventory-edit
        :inventory="window.inventoryEditProps.inventory"
        :categories="window.inventoryEditProps.categories"
        :subcategories="window.inventoryEditProps.subcategories"
        :subsubcategories="window.inventoryEditProps.subsubcategories"
        :colors="window.inventoryEditProps.colors"
        :sizes="window.inventoryEditProps.sizes"
        :variants="window.inventoryEditProps.variants"
    ></inventory-edit>
</div>
@endsection
