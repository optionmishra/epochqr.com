<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index')->with([
            'users' => $users,
        ]);
    }
    public function block(User $user)
    {
        if ($user->block()) {
            return back()->with('success', 'User blocked successfully');
        }
        return back()->with('error', 'User could not be blocked');
    }

    public function unblock(User $user)
    {
        if ($user->unblock()) {
            return back()->with('success', 'User unblocked successfully');
        }
        return back()->with('error', 'User could not be unblocked');
    }
}
