@extends('layouts_template.home')
@section('title_page','Logs Activity')

@section('content')

<table class="table table-hover">
    <tr>
        <th>No</th>
        <th>Subject</th>
        <th>URL</th>
        <th>Method</th>
        <th>IP Address</th>
        <th width="300px">User Agent</th>
        <th>Email</th>
    </tr>
        @foreach($logs as $key => $log)
        <tr>
            <td>{{ $key + $logs->firstitem()  }}</td>
            <td>{{ $log->subject }}</td>
            <td class="text-success">{{ $log->url }}</td>
            <td><label class="badge badge-info">{{ $log->method }}</label></td>
            <td class="text-warning">{{ $log->ip }}</td>
            <td class="text-danger">{{ $log->agent }}</td>
            <td>{{ $log->name }}</td>
        </tr>
        @endforeach
</table>

{{$logs->links() }}

@endsection
