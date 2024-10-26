@extends('layouts.admin')

@section('title', 'Sections')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Sections</h2>
    <a href="{{ route('sections.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Create New Section</a>

    <table id="sections-table" class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Name</th>
                <th class="py-2 px-4 border-b">Code</th>
                <th class="py-2 px-4 border-b">Department</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
    </table>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#sections-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('sections.data') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'code', name: 'code'},
                {data: 'department', name: 'department.name'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>
@endsection

