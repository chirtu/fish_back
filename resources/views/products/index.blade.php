@extends('layouts.app')

@section('content')
    <div class="bg-white shadow rounded">
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
            <h2 class="font-medium text-gray-700 leading-5">Products</h2>

            <a
                href="{{ route("products.create") }}"
                class="bg-purple-600 text-sm text-white leading-6 font-medium py-2 px-4 rounded hover:bg-purple-500"
            >New product</a>
        </div>

        <div class="admin-table-wrap text-sm mb-12">
            <table class="w-full">
                <thead>
                <tr>
                    <th class="py-3 px-4 text-left text-sm text-gray-500 font-medium bg-gray-50 border-b border-gray-100" scope="col">#</th>
                    <th class="py-3 px-4 text-left text-sm text-gray-500 font-medium bg-gray-50 border-b border-gray-100">Image</th>
                    <th class="py-3 px-4 text-left text-sm text-gray-500 font-medium bg-gray-50 border-b border-gray-100">Name</th>
                    <th class="py-3 px-4 text-left text-sm text-gray-500 font-medium bg-gray-50 border-b border-gray-100">Category</th>
                    <th class="py-3 px-4 text-left text-sm text-gray-500 font-medium bg-gray-50 border-b border-gray-100">Price</th>
                    <th class="py-3 px-4 text-left text-sm text-gray-500 font-medium bg-gray-50 border-b border-gray-100">Weight</th>
                    <th class="py-3 px-4 text-left text-sm text-gray-500 font-medium bg-gray-50 border-b border-gray-100"></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td class="py-4 px-4 border-b border-gray-100">{{ $products->firstItem() + $loop->index }}</td>
                        <td class="text-left text-sm text-gray-700 py-4 px-4 border-b border-gray-100  ">
                            @if($product->imageUrl)
                                <button type="button" data-product-photo aria-label="Enlarge image of {{ $product->name }}">
                                    <img src="{{ asset($product->imageUrl) }}" class="h-8" alt="{{ $product->name }}">
                                </button>
                            @else
                                <span class="text-gray-500">No image</span>
                            @endif
                        </td>
                        <td class="text-left text-sm text-gray-700 py-4 px-4 border-b border-gray-100">
                            {{ $product->name }}
                        </td>
                        <td class="text-left text-sm text-gray-700 py-4 px-4 border-b border-gray-100">
                            {{ $product->category->name }}
                        </td>
                        <td class="text-left text-sm text-gray-700 py-4 px-4 border-b border-gray-100">
                            Tsh {{ number_format($product->price, 2) }}
                        </td>
                        <td class="text-left text-sm text-gray-700 py-4 px-4 border-b border-gray-100">
                            {{ $product->weight .' '.  $product->weight_unit }}
                        </td>
                        <td class="text-left text-sm text-gray-700 py-4 px-6 border-b border-gray-100 flex items-center justify-between" >
                            <a href="#" class="text-sm font-medium text-purple-500 ">View</a>
                            <a href="{{ route('products.destroy', ['product' => $product->id]) }}"
                               onclick="event.preventDefault();
                               document.getElementById('delete-product-form-{{ $product->id }}').submit();"
                               class="bg-red-500 hover:bg-red-500 text-white font-bold py-2 px-4 rounded">Delete</a>
                        </td>
                    </tr>

                    <form id="delete-product-form-{{ $product->id }}"
                          action="{{ route('products.destroy', ['product' => $product->id]) }}"
                          method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    @endforeach
                </tbody>
            </table>
            @if($products->hasPages())
                <div class="admin-pagination">{{ $products->links() }}</div>
            @endif
        </div>
    </div>




    <dialog id="product-photo-dialog" class="product-photo-dialog" aria-labelledby="product-photo-title">
        <form method="dialog" class="admin-panel-heading">
            <h2 id="product-photo-title">Product image</h2>
            <button type="submit" autofocus>Close</button>
        </form>
        <img alt="">
    </dialog>

    <script>
        (() => {
            const dialog = document.getElementById('product-photo-dialog');
            const preview = dialog.querySelector('img');
            const title = document.getElementById('product-photo-title');
            for (const button of document.querySelectorAll('[data-product-photo]')) {
                button.addEventListener('click', () => {
                    const thumbnail = button.querySelector('img');
                    preview.src = thumbnail.src;
                    preview.alt = thumbnail.alt;
                    title.textContent = thumbnail.alt;
                    dialog.showModal();
                });
            }
        })();
    </script>
@endsection
