@extends('layouts.admin')

@section('title', 'Departments')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Departments</h2>
    <a href="{{ route('departments.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
        <i class="fas fa-plus mr-2"></i>Create New Department
    </a>

    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
        <table id="departments-table" class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
            <thead>
                <tr class="text-left">
                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">ID</th>
                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Name</th>
                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Code</th>
                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Actions</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#departments-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('departments.data') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'code', name: 'code'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).addClass('hover:bg-gray-100');
            }
        });
    });
</script>
@endsection
