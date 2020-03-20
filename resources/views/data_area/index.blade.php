@extends('layouts_template.home')
@section('title_page','Areas Data')
@section('content')

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach ($errors->all() as $error)
            {{ $error }} <br>
        @endforeach
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <a href="{{ route('area.create') }}" class="btn btn-info">Add Area</a><br><br>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Area Code</th>
                    <th>Area Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($area as $result => $hasil)
                <tr>
                    <td>{{ $result + $area->firstitem() }}</td>
                    <td>{{ $hasil->area_code }}</td>
                    <td><a href="#" data-id="{{ $hasil->id }}" data-code="{{ $hasil->area_code }}" data-name="{{ $hasil->area_name }}" data-toggle="modal" data-target="#showAreaModal">{{ $hasil->area_name }}</a></td>
                    <td>
                        <form action="{{ route('area.destroy', $hasil->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-primary" data-id="{{ $hasil->id }}" data-code="{{ $hasil->area_code }}"  data-name="{{ $hasil->area_name }}" data-toggle="modal" data-target="#editAreaModal">Edit</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $area->links() }}

@endsection

<!-- Modal Show -->
<div class="modal fade" id="showAreaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Show Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @method('patch')
            <div class="form-group">
                <label for="">ID</label>
                <input type="text" class="form-control" name="id" id="id"  readonly>
            </div>
            <div class="form-group">
                <label for="">Area Code</label>
                <input type="number" class="form-control" name="area_code" id="area_code" readonly>
            </div>
            <div class="form-group">
                <label for="">Area Name</label>
                <input type="text" class="form-control" name="area_name" id="area_name" readonly>
            </div>
        </div>
    </form>
    </div>
</div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editAreaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <form action="{{ route('area.update', $hasil->id) }}" method="post">
            @csrf
            @method('patch')
            <input type="hidden" name="id" id="id" value="{{ $hasil->id }}">
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
                <label for="">City Name</label>
                <select class="form-control select2" name="city_code" id="">
                    <option value="" holder>Select City</option>
                    @foreach ($cities as $result)
                        <option value="{{ $result->city_code }}">{{ $result->city_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">Area Code</label>
                <input type="number" class="form-control" name="area_code" id="area_code" required>
            </div>
            <div class="form-group">
                <label for="">Area Name</label>
                <input type="text" class="form-control" name="area_name" id="area_name" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
    </div>
</div>
</div>
