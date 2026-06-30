@extends('admin.layout')

@section('content')
<h2>Users Management</h2>
<div class="card">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>
                    <span class="badge {{ $user->status === 'active' ? 'badge-active' : 'badge-blocked' }}">
                        {{ ucfirst($user->status) }}
                    </span>
                </td>
                <td>
                    @if($user->role !== 'superadmin')
                    <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn {{ $user->status === 'active' ? 'btn-danger' : 'btn-success' }}">
                            {{ $user->status === 'active' ? 'Block' : 'Unblock' }}
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top: 20px;">
        {{ $users->links() }}
    </div>
</div>
@endsection
