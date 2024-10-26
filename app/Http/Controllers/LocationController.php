<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Section;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LocationController extends Controller
{
    public function index()
    {
        return view('locations.index');
    }

    public function getLocations()
    {
        $locations = Location::with('section.department');

        return DataTables::of($locations)
            ->addColumn('section', function ($location) {
                return $location->section->name;
            })
            ->addColumn('department', function ($location) {
                return $location->section->department->name;
            })
            ->addColumn('action', function ($location) {
                return '<a href="' . route('locations.edit', $location->id) . '" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2"><i class="fas fa-edit"></i></a>' .
                    '<a href="' . route('locations.show', $location->id) . '" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2"><i class="fas fa-eye"></i></a>' .
                    '<form action="' . route('locations.destroy', $location->id) . '" method="POST" class="inline-block">' .
                    csrf_field() .
                    method_field('DELETE') .
                    '<button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></button></form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $sections = Section::all();
        return view('locations.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|unique:locations|max:50',
            'description' => 'nullable',
            'section_id' => 'required|exists:sections,id',
        ]);

        Location::create($validatedData);

        return redirect()->route('locations.index')->with('success', 'Location created successfully.');
    }

    public function show(Location $location)
    {
        return view('locations.show', compact('location'));
    }

    public function edit(Location $location)
    {
        $sections = Section::all();
        return view('locations.edit', compact('location', 'sections'));
    }

    public function update(Request $request, Location $location)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|unique:locations,code,' . $location->id . '|max:50',
            'description' => 'nullable',
            'section_id' => 'required|exists:sections,id',
        ]);

        $location->update($validatedData);

        return redirect()->route('locations.index')->with('success', 'Location updated successfully.');
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('locations.index')->with('success', 'Location deleted successfully.');
    }
}
