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
            <label for="">Province Name</label>
            <select class="form-control select2" name="province_code" id="province">
                <option value="" holder>Select Province</option>
                @foreach ($provinces as $result)
                    <option value="{{ $result->province_code }}">{{ $result->province_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">City Name</label>
            <select class="form-control select2" name="city_code" id="city">
                <option value="" holder>Select City</option>
                @foreach ($cities as $result)
                    <option value="{{ $result->city_code }}">{{ $result->city_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">Area Code</label>
            <input type="number" class="form-control" name="area_code">
        </div>
        <div class="form-group">
            <label for="">Area Name</label>
            <input type="text" class="form-control" name="area_name">
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Add Area</button>
        </div>
    </form>

@endsection
