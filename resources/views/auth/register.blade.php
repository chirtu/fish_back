@extends('layouts.auth')
@section('title', 'Create your Fish Happy account')

@section('content')
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <x-logo class="w-auto h-16 mx-auto text-indigo-600" />
        <h1 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
            Create your Fish Happy account
        </h1>
        <p class="mt-2 text-sm text-center text-gray-600">
            Already have an account?
            <a href="{{ route('customer.login') }}" class="font-medium text-indigo-600 hover:underline">Sign in</a>
        </p>

        <div class="mt-8 px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <form method="POST" action="{{ route('customer.register.store') }}">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="name" class="block text-sm font-medium text-gray-700">Full name</label>
                    <input id="name" name="name" value="{{ old('name') }}" autocomplete="name" minlength="2" maxlength="50" required autofocus
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" />
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone number</label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel" maxlength="50" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" />
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" minlength="8" maxlength="72" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" aria-describedby="password-hint" />
                    <p id="password-hint" class="mt-1 text-sm text-gray-600">Use at least 8 characters.</p>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" />
                </div>

                <button type="submit" class="mt-6 w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-500">
                    Create account
                </button>
            </form>
        </div>
    </div>
@endsection
