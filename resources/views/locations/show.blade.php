@extends('layouts.admin')

@section('title', 'Location Details')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Location Details</h2>
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
            <p class="text-gray-700">{{ $location->name }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Code:</label>
            <p class="text-gray-700">{{ $location->code }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
            <p class="text-gray-700">{{ $location->description }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Section:</label>
            <p class="text-gray-700">{{ $location->section->name }}</p>
        </div>
        <a href="{{ route('locations.edit', $location->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Edit</a>
        <a href="{{ route('locations.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Back to List</a>
    </div>
@endsection

