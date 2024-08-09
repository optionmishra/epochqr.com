<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Click;
use App\Models\Campaign;
use App\Http\Controllers\Controller;


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
