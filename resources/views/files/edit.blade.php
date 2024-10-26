@extends('layouts.admin')

@section('title', 'Edit File')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit File</h2>
    <form action="{{ route('files.update', $file) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="file_name" class="block text-gray-700 text-sm font-bold mb-2">File Name:</label>
            <input type="text" name="file_name" id="file_name" value="{{ $file->file_name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="file_number" class="block text-gray-700 text-sm font-bold mb-2">File Number:</label>
            <input type="text" name="file_number" id="file_number" value="{{ $file->file_number }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
            <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $file->description }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Current Fixed Asset:</label>
            <p class="py-2 px-3 bg-gray-100 rounded">{{ $file->currentFixedAsset->asset_number }}</p>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update File</button>
    </form>

    <h3 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Move File</h3>
    <form action="{{ route('files.move', $file) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="new_fixed_asset_id" class="block text-gray-700 text-sm font-bold mb-2">New Fixed Asset:</label>
            <select name="new_fixed_asset_id" id="new_fixed_asset_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                @foreach($fixedAssets as $fixedAsset)
                    <option value="{{ $fixedAsset->id }}" {{ $file->current_fixed_asset_id == $fixedAsset->id ? 'selected' : '' }}>{{ $fixedAsset->asset_number }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="movement_notes" class="block text-gray-700 text-sm font-bold mb-2">Movement Notes:</label>
            <textarea name="movement_notes" id="movement_notes" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>
        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Move File</button>
    </form>
@endsection
