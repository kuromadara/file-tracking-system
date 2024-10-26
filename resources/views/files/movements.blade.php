@extends('layouts.admin')

@section('title', 'File Movements')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">File Movements for {{ $file->file_name }}</h2>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Date</th>
                <th class="py-2 px-4 border-b">From</th>
                <th class="py-2 px-4 border-b">To</th>
                <th class="py-2 px-4 border-b">Moved By</th>
                <th class="py-2 px-4 border-b">Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movements as $movement)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $movement->moved_at->format('Y-m-d H:i:s') }}</td>
                    <td class="py-2 px-4 border-b">{{ $movement->fromFixedAsset ? $movement->fromFixedAsset->asset_number : 'N/A' }}</td>
                    <td class="py-2 px-4 border-b">{{ $movement->toFixedAsset->asset_number }}</td>
                    <td class="py-2 px-4 border-b">{{ $movement->movedByUser->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $movement->notes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

