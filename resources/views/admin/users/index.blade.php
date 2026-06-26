@extends('admin.layout')

@section('header_title', 'Kelola Pelanggan')

@section('content')
<div class="content-card">
    <div class="card-header">
        <h3>Daftar Pelanggan</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th>Role</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>#{{ $user->id }}</td>
                <td>
                    <div style="font-weight: 600;">{{ $user->name }}</div>
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone ?? '-' }}</td>
                <td>
                    <span class="badge {{ $user->role == 'ADMIN' ? 'badge-gold' : 'badge-info' }}" style="{{ $user->role == 'ADMIN' ? 'background: #fff7e6; color: #fa8c16;' : '' }}">
                        {{ $user->role }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $user->active ? 'badge-success' : 'badge-danger' }}">
                        {{ $user->active ? 'Aktif' : 'Non-aktif' }}
                    </span>
                </td>
                <td>
                    @if($user->role !== 'ADMIN')
                        <form action="/admin/users/{{ $user->id }}/toggle-active" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline">
                                {{ $user->active ? 'Non-aktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding: 20px;">
        {{ $users->links() }}
    </div>
</div>
@endsection
