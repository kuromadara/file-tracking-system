@extends('layouts.admin')

@section('title', 'Create File')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Create File for {{ $fixedAsset->asset_number }}</h2>
    <form action="{{ route('files.store', $fixedAsset) }}" method="POST">
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
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create File</button>
    </form>
@endsection

