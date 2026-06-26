<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Manajemen Pelanggan: Melihat daftar user dan menonaktifkan akun jika perlu.
     */
    public function index()
    {
        $users = User::where('role', 'USER')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function toggleActive($id)
    {
        $user = User::findOrFail($id);
        $user->active = !$user->active;
        $user->save();

        return back()->with('success', 'Status akun pelanggan berhasil diubah.');
    }
}
