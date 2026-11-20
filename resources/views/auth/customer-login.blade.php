@extends('layouts.auth')
@section('title', 'Customer sign in')

@section('content')
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <x-logo class="w-auto h-16 mx-auto text-indigo-600" />
        <h1 class="mt-6 text-3xl font-extrabold text-center text-gray-900">Customer sign in</h1>
        <p class="mt-2 text-sm text-center">
            <a href="{{ route('customer.register') }}" class="font-medium text-indigo-600 hover:underline">Create an account</a>
        </p>

        <form method="POST" action="{{ route('customer.login.store') }}" class="mt-8 px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            @csrf

            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" />
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <label for="password" class="mt-6 block text-sm font-medium text-gray-700">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" />
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <button type="submit" class="mt-6 w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-500">
                Sign in
            </button>
        </form>
    </div>
@endsection
