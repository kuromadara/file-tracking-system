<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FixedAsset;
use App\Models\Department;
use App\Models\Section;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

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

    public function index()
    {
        return view('files.index');
    }

    public function createWithDropdowns()
    {
        $departments = Department::all();
        return view('files.create-with-dropdowns', compact('departments'));
    }

    public function storeWithDropdowns(Request $request)
    {
        $validatedData = $request->validate([
            'file_name' => 'required|string|max:255',
            'file_number' => 'required|string|max:255|unique:files',
            'description' => 'nullable|string',
            'fixed_asset_id' => 'required|exists:fixed_assets,id',
        ]);

        $validatedData['system_file_number'] = $this->generateSystemFileNumber();
        $validatedData['current_fixed_asset_id'] = $validatedData['fixed_asset_id'];
        unset($validatedData['fixed_asset_id']);

        $file = File::create($validatedData);

        // Create initial movement record
        $file->movements()->create([
            'from_fixed_asset_id' => null,
            'to_fixed_asset_id' => $file->current_fixed_asset_id,
            'moved_by_user_id' => auth()->id(),
            'moved_at' => now(),
            'notes' => 'Initial file creation',
        ]);

        return redirect()->route('files.index')->with('success', 'File created successfully.');
    }

    public function getSections($departmentId)
    {
        $department = Department::findOrFail($departmentId);
        return response()->json($department->sections);
    }

    public function getLocations($sectionId)
    {
        $section = Section::findOrFail($sectionId);
        return response()->json($section->locations);
    }

    public function getFixedAssets($locationId)
    {
        $location = Location::findOrFail($locationId);
        return response()->json($location->fixedAssets);
    }

    public function getFiles()
    {
        $files = File::with('currentFixedAsset.location.section.department');

        return DataTables::of($files)
            ->addColumn('fixed_asset', function ($file) {
                return $file->currentFixedAsset->asset_number;
            })
            ->addColumn('location', function ($file) {
                return $file->currentFixedAsset->location->name;
            })
            ->addColumn('section', function ($file) {
                return $file->currentFixedAsset->location->section->name;
            })
            ->addColumn('department', function ($file) {
                return $file->currentFixedAsset->location->section->department->name;
            })
            ->addColumn('action', function ($file) {
                return '<a href="' . route('files.edit', $file) . '" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2"><i class="fas fa-edit"></i></a>' .
                    '<a href="' . route('files.movements', $file) . '" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2"><i class="fas fa-history"></i></a>' .
                    '<form action="' . route('files.destroy', $file) . '" method="POST" class="inline-block">' ;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
