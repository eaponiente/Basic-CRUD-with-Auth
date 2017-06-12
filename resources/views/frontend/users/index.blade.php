@extends('layouts.master')

@section('content')

    @if( session('error') )
        <div class="alert alert-danger">{!! session('error') !!}</div>
    @endif
    @if( session('success') )
        <div class="alert alert-success">{!! session('success') !!}</div>
    @endif

    @can('edit-user')
    <div class="panel">
        <a href="{!! route('users.create') !!}" class="btn btn-primary">Create User</a>
    </div>
    @endcan
    <div class="table-bordered">
        <table class="table">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            @forelse($users as $user)
                <tr>
                    <td>{!! $user->username !!}</td>
                    <td>{!! $user->email !!}</td>
                    <td>{!! array_get(config('constants.users.roles'), $user->role) !!}</td>
                    <td>
                        @can('edit-user')
                        <a href="{!! route('users.edit', ['id' => $user->id]) !!}" class="btn btn-xs btn-success">Edit</a>
                        <form style="display: inline" method="POST" action="{!! route('users.destroy', ['id' => $user->id]) !!}">
                            {!! csrf_field() . method_field('DELETE') !!}
                            <input type="submit" class="btn btn-xs btn-danger form-inline" value="Delete">
                        </form>
                        @endcan
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="3">No User yet</td>
                </tr>
            @endforelse

        </table>
    </div>
@endsection