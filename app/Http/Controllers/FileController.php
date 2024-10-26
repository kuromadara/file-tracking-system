<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FixedAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function create(FixedAsset $fixedAsset)
    {
        return view('files.create', compact('fixedAsset'));
    }

    public function store(Request $request, FixedAsset $fixedAsset)
    {
        $validatedData = $request->validate([
            'file_name' => 'required|string|max:255',
            'file_number' => 'required|string|max:255|unique:files',
            'description' => 'nullable|string',
        ]);

        $validatedData['system_file_number'] = $this->generateSystemFileNumber();
        $validatedData['current_fixed_asset_id'] = $fixedAsset->id;

        $file = File::create($validatedData);

        // Create initial movement record
        $file->movements()->create([
            'from_fixed_asset_id' => null,
            'to_fixed_asset_id' => $fixedAsset->id,
            'moved_by_user_id' => auth()->id(),
            'moved_at' => now(),
            'notes' => 'Initial file creation',
        ]);

        return redirect()->route('fixed-assets.show', $fixedAsset)->with('success', 'File created successfully.');
    }

    public function edit(File $file)
    {
        $fixedAssets = FixedAsset::all();
        return view('files.edit', compact('file', 'fixedAssets'));
    }

    public function update(Request $request, File $file)
    {
        $validatedData = $request->validate([
            'file_name' => 'required|string|max:255',
            'file_number' => 'required|string|max:255|unique:files,file_number,' . $file->id,
            'description' => 'nullable|string',
            'current_fixed_asset_id' => 'required|exists:fixed_assets,id',
        ]);

        $file->update($validatedData);

        return redirect()->route('fixed-assets.show', $file->current_fixed_asset_id)->with('success', 'File updated successfully.');
    }

    public function destroy(File $file)
    {
        $fixedAssetId = $file->fixed_asset_id;
        $file->delete();

        return redirect()->route('fixed-assets.show', $fixedAssetId)->with('success', 'File deleted successfully.');
    }

    private function generateSystemFileNumber()
    {
        do {
            $systemFileNumber = 'SFN-' . strtoupper(Str::random(8));
        } while (File::where('system_file_number', $systemFileNumber)->exists());

        return $systemFileNumber;
    }

    public function showMovements(File $file)
    {
        $movements = $file->movements()->with(['fromFixedAsset', 'toFixedAsset', 'movedByUser'])->orderBy('moved_at', 'desc')->get();
        return view('files.movements', compact('file', 'movements'));
    }

    public function move(Request $request, File $file)
    {
        $validatedData = $request->validate([
            'new_fixed_asset_id' => 'required|exists:fixed_assets,id',
            'movement_notes' => 'nullable|string',
        ]);

        $newFixedAsset = FixedAsset::findOrFail($validatedData['new_fixed_asset_id']);

        if ($file->current_fixed_asset_id != $newFixedAsset->id) {
            $file->moveToFixedAsset($newFixedAsset, auth()->user(), $validatedData['movement_notes']);
            return redirect()->route('fixed-assets.show', $newFixedAsset)->with('success', 'File moved successfully.');
        }

        return redirect()->back()->with('info', 'File is already in the selected location.');
    }
}
