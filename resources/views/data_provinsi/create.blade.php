@extends('layouts_template.home')
@section('title_page','Add Province')
@section('content')

    @if (count($errors)>0)
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <form action="{{ route('province.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="">Province Code</label>
            <input type="number" class="form-control" name="province_code">
        </div>
        <div class="form-group">
            <label for="">Province Name</label>
            <input type="text" class="form-control" name="province_name">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Add Province</button>
        </div>
    </form>

@endsection
