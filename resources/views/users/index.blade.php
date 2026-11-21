@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="admin-heading"><h1>Users</h1></div>

    @if(session('user.name'))
        <p class="admin-notice" role="status">{{ session('user.name') }} was added.</p>
    @endif

    <section class="admin-panel mb-6" aria-labelledby="add-user">
        <div class="admin-panel-heading"><h2 id="add-user">Add user</h2></div>
        <form method="POST" action="{{ route('users.store') }}" class="px-4 pb-4">
            @csrf
            @if($errors->any())
                <ul class="mb-4 text-red-700" role="alert">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <div class="grid gap-4 sm:grid-cols-2">
                <label class="block">
                    Name
                    <input class="block w-full px-3 py-2 border rounded-md" name="name" value="{{ old('name') }}" maxlength="255" required>
                </label>
                <label class="block">
                    Email
                    <input class="block w-full px-3 py-2 border rounded-md" name="email" type="email" value="{{ old('email') }}" maxlength="255" required>
                </label>
                <label class="block">
                    Password
                    <input class="block w-full px-3 py-2 border rounded-md" name="password" type="password" autocomplete="new-password" minlength="12" maxlength="72" required>
                </label>
                <label class="block">
                    Role
                    <select class="block w-full px-3 py-2 border rounded-md" name="role" required>
                        <option value="user" @selected(old('role', 'user') === 'user')>User</option>
                        <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                    </select>
                </label>
            </div>
            <button class="admin-button mt-4" type="submit">Add user</button>
        </form>
    </section>

    <section class="admin-panel" aria-label="User accounts">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr><th scope="col">Name</th><th scope="col">Email</th><th scope="col">Role</th><th scope="col">Created</th></tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="admin-status">{{ ucfirst($user->role) }}</span></td>
                            <td>{{ $user->created_at?->format('d M Y') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="admin-empty">No users yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="admin-pagination">{{ $users->links() }}</div>
        @endif
    </section>
@endsection
