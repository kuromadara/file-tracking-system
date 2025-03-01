<?php

namespace App\Http\Controllers;

use App\Models\FixedAsset;
use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FixedAssetController extends Controller
{
    public function index()
    {
        return view('fixed-assets.index');
    }

    public function getFixedAssets()
    {
        $fixedAssets = FixedAsset::with('location.section.department');

        return DataTables::of($fixedAssets)
            ->addColumn('location', function ($fixedAsset) {
                return $fixedAsset->location->name;
            })
            ->addColumn('section', function ($fixedAsset) {
                return $fixedAsset->location->section->name;
            })
            ->addColumn('department', function ($fixedAsset) {
                return $fixedAsset->location->section->department->name;
            })
            ->addColumn('action', function ($fixedAsset) {
                return '<a href="' . route('fixed-assets.edit', $fixedAsset->id) . '" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2"><i class="fas fa-edit"></i></a>' .
                    '<a href="' . route('fixed-assets.show', $fixedAsset->id) . '" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2"><i class="fas fa-eye"></i></a>' .
                    '<form action="' . route('fixed-assets.destroy', $fixedAsset->id) . '" method="POST" class="inline-block">' .
                    csrf_field() .
                    method_field('DELETE') .
                    '<button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></button></form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $locations = Location::all();
        return view('fixed-assets.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'asset_number' => 'required|unique:fixed_assets|max:50',
            'location_id' => 'required|exists:locations,id',
        ]);

        FixedAsset::create($validatedData);

        return redirect()->route('fixed-assets.index')->with('success', 'Fixed Asset created successfully.');
    }

    public function show(FixedAsset $fixedAsset)
    {
        $fixedAsset->load('files');
        return view('fixed-assets.show', compact('fixedAsset'));
    }

    public function edit(FixedAsset $fixedAsset)
    {
        $locations = Location::all();
        return view('fixed-assets.edit', compact('fixedAsset', 'locations'));
    }

    public function update(Request $request, FixedAsset $fixedAsset)
    {
        $validatedData = $request->validate([
            'asset_number' => 'required|unique:fixed_assets,asset_number,' . $fixedAsset->id . '|max:50',
            'location_id' => 'required|exists:locations,id',
        ]);

        $fixedAsset->update($validatedData);

        return redirect()->route('fixed-assets.index')->with('success', 'Fixed Asset updated successfully.');
    }

    public function destroy(FixedAsset $fixedAsset)
    {
        $fixedAsset->delete();

        return redirect()->route('fixed-assets.index')->with('success', 'Fixed Asset deleted successfully.');
    }
}
