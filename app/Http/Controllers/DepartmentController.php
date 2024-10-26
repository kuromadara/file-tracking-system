<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('departments.index');
    }

    public function getDepartments()
    {
        $departments = Department::query();

        return DataTables::of($departments)
            ->addColumn('action', function ($department) {
                return '<a href="' . route('departments.edit', $department->id) . '" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2"><i class="fas fa-edit"></i></a>' .
                    '<a href="' . route('departments.show', $department->id) . '" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2"><i class="fas fa-eye"></i></a>' .
                    '<form action="' . route('departments.destroy', $department->id) . '" method="POST" class="inline-block">' .
                    csrf_field() .
                    method_field('DELETE') .
                    '<button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></button></form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|unique:departments|max:50',
            'description' => 'nullable',
        ]);

        Department::create($validatedData);

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|unique:departments,code,' . $department->id . '|max:50',
            'description' => 'nullable',
        ]);

        $department->update($validatedData);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
