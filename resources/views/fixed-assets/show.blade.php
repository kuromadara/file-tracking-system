@extends('layouts.admin')

@section('title', 'Fixed Asset Details')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Fixed Asset Details</h2>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Asset Information
            </h3>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Asset Number
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $fixedAsset->asset_number }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Location
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $fixedAsset->location->name }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Section
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $fixedAsset->location->section->name }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Department
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $fixedAsset->location->section->department->name }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <h3 class="text-xl font-semibold text-gray-800 mt-8 mb-4">Files</h3>
    <a href="{{ route('files.create', $fixedAsset) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Add New File</a>

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">File Name</th>
                <th class="py-2 px-4 border-b">File Number</th>
                <th class="py-2 px-4 border-b">System File Number</th>
                <th class="py-2 px-4 border-b">Description</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fixedAsset->files as $file)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $file->file_name }}</td>
                    <td class="py-2 px-4 border-b">{{ $file->file_number }}</td>
                    <td class="py-2 px-4 border-b">{{ $file->system_file_number }}</td>
                    <td class="py-2 px-4 border-b">{{ $file->description }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('files.edit', $file) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Edit</a>
                        <a href="{{ route('files.movements', $file) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">View Movements</a>
                        <form action="{{ route('files.destroy', $file) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" onclick="return confirm('Are you sure you want to delete this file?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <a href="{{ route('fixed-assets.edit', $fixedAsset->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        <form action="{{ route('fixed-assets.destroy', $fixedAsset->id) }}" method="POST" class="inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this fixed asset?')">Delete</button>
        </form>
    </div>
@endsection
