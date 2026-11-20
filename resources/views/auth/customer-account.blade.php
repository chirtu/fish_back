@extends('layouts.auth')
@section('title', 'Your account')

@section('content')
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <x-logo class="w-auto h-16 mx-auto text-indigo-600" />
        <div class="mt-8 px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
            <h1 class="text-2xl font-extrabold text-gray-900">Welcome, {{ auth('customer')->user()->name }}</h1>
            <p class="mt-2 text-sm text-gray-600">{{ auth('customer')->user()->email }}</p>

            <form method="POST" action="{{ route('customer.logout') }}" class="mt-6">
                @csrf
                <button type="submit" class="font-medium text-indigo-600 hover:underline">Sign out</button>
            </form>
        </div>
    </div>
@endsection
