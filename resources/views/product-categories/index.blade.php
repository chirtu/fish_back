@extends('layouts.app')

@section('content')
    <div class="bg-white shadow rounded">
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
            <h2 class="font-medium text-gray-700 leading-5">Product categories</h2>

            <div x-data="{ open: @js($errors->hasAny(['name', 'description'])) }">
                <button
                    type="button"
                    @click="open = true"
                    class="bg-purple-600 text-sm text-white leading-6 font-medium py-2 px-4 rounded hover:bg-purple-500"
                >New category</button>

                <form
                    method="POST"
                    action="{{ route("productCategories.store") }}"
                    x-show="open"
                    @keydown.escape.window="open = false"
                    class="fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center"
                >
                    @csrf

                    <div class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <div
                        class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full"
                        role="dialog"
                        aria-modal="true"
                        aria-labelledby="modal-headline"
                        @click.away="open = false"
                    >
                        <div class="bg-white px-6 pt-5 pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="w-full text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                        New product category
                                    </h3>
                                    <div class="space-y-6 mt-6">
                                        <div>
                                            <label for="name" class="text-sm text-gray-600 font-medium">Category name</label>
                                            <input
                                                type="text"
                                                id="name"
                                                name="name"
                                                class="form-input w-full mt-2 text-sm"
                                                placeholder="e.g. Saltwater fish"
                                                value="{{ old('name') }}"
                                                maxlength="255"
                                                required
                                            >
                                            @error('name')
                                                <p class="mt-2 text-sm text-red-700" role="alert">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="description" class="text-sm text-gray-600 font-medium">Description</label>
                                            <textarea
                                                id="description"
                                                name="description"
                                                class="form-textarea w-full mt-2 text-sm"
                                                rows="5"
                                                placeholder="Describe which products belong in this category"
                                                required
                                            >{{ old('description') }}</textarea>
                                            @error('description')
                                                <p class="mt-2 text-sm text-red-700" role="alert">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-purple-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-purple-500 focus:outline-none focus:border-purple-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                    Create category
                                </button>
                            </span>

                            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                <button
                                    type="button"
                                    class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                                    @click.prevent="open = false"
                                >
                                    Cancel
                                </button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-sm mb-12">
            <table class="w-full">
                <thead>
                <tr>
                    <th class="py-3 px-4 text-left text-sm text-gray-500 font-medium bg-gray-50 border-b border-gray-100">Name</th>
                    <th class="py-3 px-4 text-right text-sm text-gray-500 font-medium bg-gray-50 border-b border-gray-100"></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td class="text-left text-sm text-gray-700 py-4 px-4 border-b border-gray-100">
                            {{ $category->name }}
                        </td>
                        <td class="text-right text-sm text-gray-700 py-4 px-4 border-b border-gray-100">
                            <a href="#" class="text-sm font-medium text-purple-500">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
