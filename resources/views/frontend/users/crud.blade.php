@extends('layouts.master')

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{!! isset($edit) ? route('users.update', ['id' => $edit->id]) : route('users.store') !!}">
        {!! csrf_field() !!}
        {!! isset($edit) ? method_field('PUT') : method_field('POST') !!}
        <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Username" value="{!! isset($edit) ? $edit->username : old('username') !!}">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="email" class="form-control" placeholder="Email" value="{!! isset($edit) ? $edit->email : old('email') !!}">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Role</label>
            <select name="role" class="form-control">
                @foreach(config('constants.users.roles') as $key => $v)
                    <option value="{!! $key !!}" {!! (isset($edit) && $edit->role == $key) || ( old('role') && old('role') == $key) ? 'selected' : '' !!}>{!! $v !!}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password">
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Password">
        </div>

        <button type="submit" class="btn btn-default">Submit</button>
        <a href="{!! route('users.index') !!}" class="btn btn-primary">Back</a>
    </form>
@endsection