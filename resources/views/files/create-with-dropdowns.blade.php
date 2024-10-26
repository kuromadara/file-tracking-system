@extends('layouts.admin')

@section('title', 'Create File')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Create File</h2>
    <form action="{{ route('files.store-with-dropdowns') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="file_name" class="block text-gray-700 text-sm font-bold mb-2">File Name:</label>
            <input type="text" name="file_name" id="file_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="file_number" class="block text-gray-700 text-sm font-bold mb-2">File Number:</label>
            <input type="text" name="file_number" id="file_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
            <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>
        <div class="mb-4">
            <label for="department_id" class="block text-gray-700 text-sm font-bold mb-2">Department:</label>
            <select name="department_id" id="department_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">Select Department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="section_id" class="block text-gray-700 text-sm font-bold mb-2">Section:</label>
            <select name="section_id" id="section_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required disabled>
                <option value="">Select Section</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="location_id" class="block text-gray-700 text-sm font-bold mb-2">Location:</label>
            <select name="location_id" id="location_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required disabled>
                <option value="">Select Location</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="fixed_asset_id" class="block text-gray-700 text-sm font-bold mb-2">Fixed Asset:</label>
            <select name="fixed_asset_id" id="fixed_asset_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required disabled>
                <option value="">Select Fixed Asset</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create File</button>
    </form>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function showLoading(element) {
            $(element).prop('disabled', true).append('<span class="ml-2 spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
        }

        function hideLoading(element) {
            $(element).prop('disabled', false).find('.spinner-border').remove();
        }

        $('#department_id').change(function() {
            var departmentId = $(this).val();
            var $sectionSelect = $('#section_id');
            var $locationSelect = $('#location_id');
            var $fixedAssetSelect = $('#fixed_asset_id');

            if (departmentId) {
                showLoading(this);
                $.ajax({
                    url: "{{ route('files.get-sections', ':id') }}".replace(':id', departmentId),
                    type: 'GET',
                    data: { department_id: departmentId },
                    dataType: 'json',
                    success: function(data) {
                        $sectionSelect.empty().append('<option value="">Select Section</option>').prop('disabled', false);
                        $.each(data, function(key, value) {
                            $sectionSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching sections:", error);
                        alert("Error fetching sections. Please try again.");
                    },
                    complete: function() {
                        hideLoading('#department_id');
                    }
                });
            } else {
                $sectionSelect.empty().append('<option value="">Select Section</option>').prop('disabled', true);
                $locationSelect.empty().append('<option value="">Select Location</option>').prop('disabled', true);
                $fixedAssetSelect.empty().append('<option value="">Select Fixed Asset</option>').prop('disabled', true);
            }
        });

        $('#section_id').change(function() {
            var sectionId = $(this).val();
            var $locationSelect = $('#location_id');
            var $fixedAssetSelect = $('#fixed_asset_id');

            if (sectionId) {
                showLoading(this);
                $.ajax({
                    url: "{{ route('files.get-locations', ':id') }}".replace(':id', sectionId),
                    type: 'GET',
                    data: { section_id: sectionId },
                    dataType: 'json',
                    success: function(data) {
                        $locationSelect.empty().append('<option value="">Select Location</option>').prop('disabled', false);
                        $.each(data, function(key, value) {
                            $locationSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching locations:", error);
                        alert("Error fetching locations. Please try again.");
                    },
                    complete: function() {
                        hideLoading('#section_id');
                    }
                });
            } else {
                $locationSelect.empty().append('<option value="">Select Location</option>').prop('disabled', true);
                $fixedAssetSelect.empty().append('<option value="">Select Fixed Asset</option>').prop('disabled', true);
            }
        });

        $('#location_id').change(function() {
            var locationId = $(this).val();
            var $fixedAssetSelect = $('#fixed_asset_id');

            if (locationId) {
                showLoading(this);
                $.ajax({
                    url: "{{ route('files.get-fixed-assets', ':id') }}".replace(':id', locationId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $fixedAssetSelect.empty().append('<option value="">Select Fixed Asset</option>').prop('disabled', false);
                        $.each(data, function(key, value) {
                            $fixedAssetSelect.append('<option value="' + value.id + '">' + value.asset_number + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching fixed assets:", error);
                        alert("Error fetching fixed assets. Please try again.");
                    },
                    complete: function() {
                        hideLoading('#location_id');
                    }
                });
            } else {
                $fixedAssetSelect.empty().append('<option value="">Select Fixed Asset</option>').prop('disabled', true);
            }
        });
    });
</script>
@endsection
