<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sections.index');
    }

    public function getSections()
    {
        $sections = Section::with('department');

        return DataTables::of($sections)
            ->addColumn('department', function ($section) {
                return $section->department->name;
            })
            ->addColumn('action', function ($section) {
                return '<a href="' . route('sections.edit', $section->id) . '" class="btn btn-xs btn-primary">Edit</a> ' .
                    '<a href="' . route('sections.show', $section->id) . '" class="btn btn-xs btn-info">View</a> ' .
                    '<form action="' . route('sections.destroy', $section->id) . '" method="POST" style="display:inline">' .
                    csrf_field() .
                    method_field('DELETE') .
                    '<button type="submit" class="btn btn-xs btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button></form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('sections.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|unique:sections|max:50',
            'description' => 'nullable',
            'department_id' => 'required|exists:departments,id',
        ]);

        Section::create($validatedData);

        return redirect()->route('sections.index')->with('success', 'Section created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        return view('sections.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        $departments = Department::all();
        return view('sections.edit', compact('section', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|unique:sections,code,' . $section->id . '|max:50',
            'description' => 'nullable',
            'department_id' => 'required|exists:departments,id',
        ]);

        $section->update($validatedData);

        return redirect()->route('sections.index')->with('success', 'Section updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $section->delete();

        return redirect()->route('sections.index')->with('success', 'Section deleted successfully.');
    }
}
