<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function toggleActive($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'ADMIN') {
            return back()->with('error', 'Admin tidak bisa dinon-aktifkan.');
        }
        
        $user->active = !$user->active;
        $user->save();

        return back()->with('success', 'Status user berhasil diperbarui.');
    }
}
