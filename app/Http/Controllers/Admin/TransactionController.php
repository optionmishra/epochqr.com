<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Click;

class TransactionController extends Controller
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
        $clicks = Click::paginate(10);

        return view('admin.transactions.clicks')->with([
            'clicks' => $clicks,
        ]);
    }

    //

}
