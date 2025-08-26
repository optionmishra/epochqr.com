<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Click;
use App\Models\Project;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $data = [
            'total_users' => User::count(),
            'total_projects' => Project::count(),
            'total_qrs' => Campaign::count(),
            'total_clicks' => Click::count(),
        ];

        return view('admin.index')->with($data);
    }
}
