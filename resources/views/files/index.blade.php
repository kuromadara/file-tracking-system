@extends('layouts.admin')

@section('title', 'Files')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Files</h2>
    <a href="{{ route('files.create-with-dropdowns') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Create New File</a>

    <table id="files-table" class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">File Name</th>
                <th class="py-2 px-4 border-b">File Number</th>
                <th class="py-2 px-4 border-b">System File Number</th>
                <th class="py-2 px-4 border-b">Fixed Asset</th>
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
        $('#files-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('files.data') }}",
            columns: [
                {data: 'file_name', name: 'file_name'},
                {data: 'file_number', name: 'file_number'},
                {data: 'system_file_number', name: 'system_file_number'},
                {data: 'fixed_asset', name: 'currentFixedAsset.asset_number'},
                {data: 'location', name: 'currentFixedAsset.location.name'},
                {data: 'section', name: 'currentFixedAsset.location.section.name'},
                {data: 'department', name: 'currentFixedAsset.location.section.department.name'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>
@endsection
