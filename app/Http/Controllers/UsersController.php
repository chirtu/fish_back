<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('users.index', [
            'users' => User::latest()->paginate(),
        ]);
    }

    public function store(UserStoreRequest $request)
    {
        $user = new User($request->safe()->only(['name', 'email', 'password']));
        $user->role = $request->validated('role', User::ROLE_USER);
        $user->save();

        $request->session()->flash('user.name', $user->name);

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
