<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = auth()->user();
        // dd($user);
        $projects = $user->projects()->where('archived', 0)->orderBy('name', 'asc')->paginate(50);
        $archived_projects = $user->projects()->where('archived', 1)->orderBy('name', 'asc')->paginate(50);
        // $projects = Project::paginate(10);
        return view('projects', compact('projects', 'archived_projects'));
    }
    public function store(Request $request)
    {
        $user =  auth()->user();
        $project_exist = Project::where('name', $request->input('name'))->get();

        if ($project_exist->count() > 0) {
            return back()->with('error', 'Project already exists, please choose a different name.');
        } else {
            $data = [
                'name'         => $request->input('name'),
            ];
            $create_project = $user->projects()->create($data);
            if ($create_project) {
                return back()->with('message', 'Project Created Successfully!');
            }
            return back()->with('error', 'Project Creation Failed!');
        }
    }
    public function destroy(Project $project)
    {
        if ($project->delete()) {
            return back()->with('message', 'Project "' . $project->name . '" Deleted successfully!');
        }
        return back()->with('error', 'Delete Failed!');
    }

    public function archive(Project $project)
    {
        $project->archived = 1;
        if ($project->save()) {
            return back()->with('success', 'Project archived successfully');
        }
        return back()->with('error', 'Project archive Failed');
    }

    public function unarchive(Project $project)
    {
        $project->archived = 0;
        if ($project->save()) {
            return back()->with('success', 'Project unarchived successfully');
        }
        return back()->with('error', 'Project unarchive Failed');
    }

    public function update(Request $request, Project $project)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $oldName = $project->name;
        $newName = $request->input('name');

        if ($oldName !== $newName) {
            // Correctly resolve the file paths using Laravel's helper functions
            $oldPath = public_path('storage/campaign/' . str_replace(' ', '_', $oldName));
            $newPath = public_path('storage/campaign/' . str_replace(' ', '_', $newName));

            if (file_exists($oldPath)) {
                if (file_exists($newPath)) {
                    return back()->with('error', 'Project already exists, please choose a different name.');
                }
                // Check if renaming works before proceeding
                if (rename($oldPath, $newPath)) {
                    $project->name = $newName;
                } else {
                    return back()->with('error', 'Failed to rename the project folder');
                }
            } else {
                return back()->with('error', 'Old project folder not found');
            }
        }

        // Save the project and return response based on success or failure
        if ($project->save()) {
            return back()->with('success', 'Project updated successfully');
        } else {
            return back()->with('error', 'Project update failed');
        }
    }
}
