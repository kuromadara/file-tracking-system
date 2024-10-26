@extends('layouts.admin')

@section('title', 'Fixed Assets')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Fixed Assets</h2>
    <a href="{{ route('fixed-assets.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Create New Fixed Asset</a>

    <table id="fixed-assets-table" class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Asset Number</th>
                <th class="py-2 px-4 border-b">Location</th>
                <th class="py-2 px-4 border-b">Section</th>
                <th class="py-2 px-4 border-b">Department</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
    </table>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#fixed-assets-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('fixed-assets.data') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'asset_number', name: 'asset_number'},
                {data: 'location', name: 'location'},
                {data: 'section', name: 'section'},
                {data: 'department', name: 'department'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>
@endsection

