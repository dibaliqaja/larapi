@extends('layouts_template.home')
@section('title_page','Data Provinsi')
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

    <a href="{{ route('province.create') }}" class="btn btn-info">Add Province</a><br><br>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name Provinsi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($province as $result => $hasil)
                <tr>
                    <td>{{ $result + $province->firstitem() }}</td>
                    <td><a href="#" data-id="{{ $hasil->id }}" data-name="{{ $hasil->province_name }}" data-toggle="modal" data-target="#showProvinceModal">{{ $hasil->province_name }}</a></td>
                    <td>
                        <form action="{{ route('province.destroy', $hasil->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-primary" data-id="{{ $hasil->id }}" data-name="{{ $hasil->province_name }}" data-toggle="modal" data-target="#editProvinceModal">Edit</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $province->links() }}

@endsection

<!-- Modal Show -->
<div class="modal fade" id="showProvinceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                <label for="">Name</label>
                <input type="text" class="form-control" name="province_name" id="province_name" readonly>
            </div>
        </div>
    </form>
    </div>
</div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editProvinceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
        <form action="{{ route('province.update', $hasil->id) }}" method="post">
            @csrf
            @method('patch')
            <input type="hidden" name="id" id="id" value="{{ $hasil->id }}">
            <div class="form-group">
                <label for="">Name</label>
                <input type="text" class="form-control" name="province_name" id="province_name" required>
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
