@extends('layouts_template.home')
@section('title_page','Add User')
@section('content')

    @if (count($errors)>0)
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <form action="{{ route('user.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="form-group">
            <label for="">Email Address</label>
            <input type="email" class="form-control" name="email">
        </div>
        <div class="form-group">
            <label for="">Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Add User</button>
        </div>
    </form>

@endsection
