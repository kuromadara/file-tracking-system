@extends('layouts.admin')

@section('title', 'Create Fixed Asset')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Create Fixed Asset</h2>
    <form action="{{ route('fixed-assets.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="asset_number" class="block text-gray-700 text-sm font-bold mb-2">Asset Number:</label>
            <input type="text" name="asset_number" id="asset_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="location_id" class="block text-gray-700 text-sm font-bold mb-2">Location:</label>
            <select name="location_id" id="location_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create Fixed Asset</button>
    </form>
@endsection

