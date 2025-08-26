<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $projects = Project::paginate(10);

        return view('admin.project.index', compact('projects'));
    }

    public function store(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
        ];
        $create_project = Project::create($data);

        if ($create_project) {
            return redirect()->route('admin.projects.index');
        }

        return redirect()->route('admin.projects.index')->with('error creating project!!');
    }
}
