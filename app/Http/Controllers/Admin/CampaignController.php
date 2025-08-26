<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CampaignController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:admin');
    }

    public function index(Project $project)
    {
        // $campaigns = Campaign::get();
        $campaigns = $project->campaigns()->paginate(50);
        $qrPath = '/storage/campaign/img/';

        return view('admin.campaign.offers', compact('project', 'campaigns', 'qrPath'));
    }

    public function form()
    {
        return view('admin.campaign.new.form');
    }

    public function formProcess(Project $project, Request $request)
    {
        $domainUrl = env('APP_URL');

        // Unique Id
        $randomid = $this->generateBarcodeNumber();

        $data = [
            'title' => $request->input('title'),
            'qrcode' => 'test',
            'link' => $randomid,
            'target' => $request->input('target_url'),
            'status' => $request->input('status'),
        ];

        $campaign = $project->campaigns()->create($data);

        // $directory = '../public/files/offer/'.$campaign->id;

        // $destinationPath = $directory."/";

        // $this->checkDir($directory, $campaign->id);

        $logo = QrCode::format('png')
            ->merge('img/QRcode.png', 0.1, true)
            ->size(200)->errorCorrection('H')
            ->generate($domainUrl.'/'.$campaign->link);
        $qrName = time().'.png';
        $output_file = 'public/campaign/img/'.$campaign->id.'/'.$qrName;
        \Storage::disk('local')->put($output_file, $logo);

        if ($campaign) {

            Campaign::where('id', '=', $campaign->id)->update(['qrcode' => $qrName]);

            return redirect()->route('admin.campaigns.index', $project);
        }

        return view('admin.index');
    }

    /*
    * Generate Unique Id
    *
    */
    public function generateBarcodeNumber()
    {

        $number = Str::random(8);

        // call the same function if the exists already
        if ($this->barcodeNumberExists($number)) {
            return $this->generateBarcodeNumber();
        }

        // otherwise, it's valid and can be used
        return $number;
    }

    /*
    * Check Unique Id
    *
    */
    public function barcodeNumberExists($number)
    {
        return Campaign::where('link', $number)->exists();
    }

    /*
     * check Directory
    */
    public function checkDir($directory, $id)
    {
        if (! file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
    }
}
