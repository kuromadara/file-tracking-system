@extends('layouts.admin')

@section('title', 'Edit Section')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Section</h2>
    <form action="{{ route('sections.update', $section->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
            <input type="text" name="name" id="name" value="{{ $section->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Code:</label>
            <input type="text" name="code" id="code" value="{{ $section->code }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
            <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $section->description }}</textarea>
        </div>
        <div class="mb-4">
            <label for="department_id" class="block text-gray-700 text-sm font-bold mb-2">Department:</label>
            <select name="department_id" id="department_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ $section->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Section</button>
    </form>
@endsection

