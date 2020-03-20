@extends('layouts_template.home')
@section('title_page','Add City')
@section('content')

    @if (count($errors)>0)
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <form action="{{ route('city.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="">Province Name</label>
            <select class="form-control select2" name="province_code" id="">
                <option value="" holder>Select Province</option>
                @foreach ($provinces as $result)
                    <option value="{{ $result->province_code }}">{{ $result->province_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">City Code</label>
            <input type="number" class="form-control" name="city_code">
        </div>
        <div class="form-group">
            <label for="">City Name</label>
            <input type="text" class="form-control" name="city_name">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Add City</button>
        </div>
    </form>

@endsection
