@extends('layouts_template.home')
@section('title_page','Add Area')
@section('content')

    @if (count($errors)>0)
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <form action="{{ route('area.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="">Area Name</label>
            <input type="text" class="form-control" name="area_name">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Add Area</button>
        </div>
    </form>

@endsection
