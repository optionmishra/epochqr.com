<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Project;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use ZipArchive;

class QrController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Project $project)
    {
        // dd(date('dmY-h:i:s'));
        // $campaigns = Campaign::get();
        $campaigns = $project->campaigns()->where('archived', 0)->orderBy('title', 'asc')->get();
        $archived_campaigns = $project->campaigns()->where('archived', 1)->orderBy('title', 'asc')->get();
        $qrPath = '/storage/campaign/';
        $domainUrl = config('app.url');
        // dd($domainUrl);

        return view('qr-codes', compact('project', 'campaigns', 'archived_campaigns', 'qrPath', 'domainUrl'));
    }

    public function formProcess(Project $project, Request $request)
    {
        $domainUrl = config('app.url');
        // Unique Id
        $randomid = $this->generateBarcodeNumber();
        $target = $request->input('qr_type') == 'url' ? $request->input('target_url') : $request->input('target_code');
        $data = [
            'title' => $request->input('title'),
            'type' => $request->input('qr_type'),
            'qrcode' => 'test',
            'link' => $randomid,
            'target' => $target,
            'status' => $request->input('status'),
        ];
        $campaign = $project->campaigns()->create($data);

        // $directory = '../public/files/offer/'.$campaign->id;
        // $destinationPath = $directory."/";
        // $this->checkDir($directory, $campaign->id);

        $logo = QrCode::format('png')
            ->merge('img/QRcode.png', 0.1, true)
            ->size(200)->errorCorrection('H')
            ->generate($domainUrl.$campaign->link);
        // $qrName = time() . '.png';
        // $qrName = $data['title'] . '.png';
        $qrName = $data['title'].'-'.date('dmY-h:i:s').'.png';
        $output_file = 'public/campaign/'.str_replace(' ', '_', $project->name).'/'.str_replace(' ', '_', $qrName);
        Storage::disk('local')->put($output_file, $logo);

        if ($campaign) {
            Campaign::where('id', '=', $campaign->id)->update(['qrcode' => $qrName]);

            return redirect()->route('qr-codes.index', $project);
        }
    }

    // public function multiple_store(Project $project, Request $request)
    // {
    //     // uploading the file
    //     $uploadedFile = $request->file('file');
    //     $filename = time() . $uploadedFile->getClientOriginalName();

    //     Storage::disk('local')->putFileAs(
    //         'files/multiple_qr/' . str_replace(' ', '_', $project->name),
    //         $uploadedFile,
    //         $filename
    //     );
    //     // read the file
    //     $filepath = storage_path() . '/app/files/multiple_qr/' . str_replace(' ', '_', $project->name) . '/' . $filename;
    //     $qrs = [];
    //     if (($open = fopen($filepath, 'r')) !== FALSE) {
    //         while (($data = fgetcsv($open, 10000, ",")) !== FALSE) {
    //             $qrs[] = $data;
    //         }
    //         fclose($open);
    //     }
    //     // operations on each entry
    //     $domainUrl = config('app.url');
    //     $data = array();
    //     $qr_type = $request->input('qr_type');
    //     foreach ($qrs as $key => $qr) {
    //         $qrName = $qr[0] . '-' . date('dmY-h:i:s-') . $key . '.png';
    //         $randomid = $this->generateBarcodeNumber();
    //         if (isset($qr[0]) &&  $qr[0] != '') {
    //             $data[] = [
    //                 'title' => $qr[0],
    //                 'type' => $qr_type,
    //                 'qrcode' => $qrName,
    //                 'link' => $randomid,
    //                 'target' => isset($qr[1]) ? $qr[1] : null,
    //                 'status' => 1
    //             ];
    //         }
    //         //  else {
    //         //     return back()->with('error', 'Error Occured while parsing the uploaded file.Please check uploaded file.');
    //         // }
    //     }
    //     $campaign = $project->campaigns()->createMany($data);
    //     foreach ($campaign as $key => $camp) {
    //         $target = $qr_type == 'Code' ? $camp['target'] : $domainUrl . $camp['link'];
    //         $logo = QrCode::format('png')
    //             ->merge('img/QRcode.png', 0.1, true)
    //             ->size(200)->errorCorrection('H')
    //             ->generate($target);

    //         $output_file = 'public/campaign/' . str_replace(' ', '_', $project->name) . '/' . str_replace(' ', '_', $camp['qrcode']);
    //         Storage::disk('local')->put($output_file, $logo);
    //     }
    //     return redirect()->route('qr-codes.index', $project);
    // }

    public function multiple_store(Project $project, Request $request)
    {
        // uploading the file
        $uploadedFile = $request->file('file');
        $filename = time().'-'.$uploadedFile->getClientOriginalName();
        $filename = str_replace(' ', '_', $filename);

        // Sanitize project name
        $projectName = str_replace(' ', '_', $project->name);
        $projectName = preg_replace('/[^A-Za-z0-9_\-]/', '', $projectName);

        Storage::disk('local')->putFileAs(
            'files/multiple_qr/'.$projectName,
            $uploadedFile,
            $filename
        );

        // read the file
        $filepath = storage_path().'/app/files/multiple_qr/'.$projectName.'/'.$filename;
        $qrs = [];
        if (($open = fopen($filepath, 'r')) !== false) {
            while (($data = fgetcsv($open, 10000, ',')) !== false) {
                $qrs[] = $data;
            }
            fclose($open);
        }

        // operations on each entry
        $domainUrl = config('app.url');
        $data = [];
        $qr_type = $request->input('qr_type');
        foreach ($qrs as $key => $qr) {
            $qrName = $qr[0].'-'.date('dmY-h_i_s-').$key.'.png';
            $qrName = str_replace(' ', '_', $qrName);
            $qrName = preg_replace('/[^A-Za-z0-9_\-\.]/', '', $qrName);

            $randomid = $this->generateBarcodeNumber();
            if (isset($qr[0]) && $qr[0] != '') {
                $data[] = [
                    'title' => $qr[0],
                    'type' => $qr_type,
                    'qrcode' => $qrName,
                    'link' => $randomid,
                    'target' => isset($qr[1]) ? $qr[1] : null,
                    'status' => 1,
                ];
            }
        }

        $campaign = $project->campaigns()->createMany($data);
        foreach ($campaign as $key => $camp) {
            $target = $qr_type == 'Code' ? $camp['target'] : $domainUrl.$camp['link'];
            $logo = QrCode::format('png')
                ->merge('img/QRcode.png', 0.1, true)
                ->size(200)->errorCorrection('H')
                ->generate($target);

            $output_file = 'public/campaign/'.$projectName.'/'.$camp['qrcode'];
            Storage::disk('local')->put($output_file, $logo);
        }

        return redirect()->route('qr-codes.index', $project);
    }

    public function multiple_download(Request $request)
    {
        try {
            $project_name = str_replace(' ', '_', $request->input('project'));
            $qrIDs = $request->input('qrIDs');
            $campaigns = Campaign::whereIn('id', $qrIDs)->get();

            if ($campaigns->isEmpty()) {
                return response()->json(['error' => 'No campaigns found'], 404);
            }

            $zip = new ZipArchive;
            $fileName = $project_name.'_'.time().'.zip';
            $zipFilePath = public_path('storage/download/'.$fileName);

            // Ensure directory exists
            $downloadDir = dirname($zipFilePath);
            if (! is_dir($downloadDir)) {
                mkdir($downloadDir, 0755, true);
            }

            // Open zip file
            if ($zip->open($zipFilePath, ZipArchive::CREATE) !== true) {
                return response()->json(['error' => 'Cannot create zip file'], 500);
            }

            $domainUrl = config('app.url');

            switch ($request->fileType) {
                case 'svg':
                    foreach ($campaigns as $campaign) {
                        $svgContent = QrCode::format('svg')
                            ->merge('img/QRcode.png', 0.1, true)
                            ->size(300)->errorCorrection('H')
                            ->generate($domainUrl.$campaign->link);

                        $baseFilename = pathinfo($campaign->qrcode, PATHINFO_FILENAME);
                        $filename = str_replace(' ', '_', $baseFilename).'.svg';
                        $zip->addFromString($filename, $svgContent);
                    }
                    break;

                case 'eps':
                    foreach ($campaigns as $campaign) {
                        $epsContent = QrCode::format('eps')
                            ->merge('img/QRcode.png', 0.1, true)
                            ->size(300)->errorCorrection('H')
                            ->generate($domainUrl.$campaign->link);

                        $baseFilename = pathinfo($campaign->qrcode, PATHINFO_FILENAME);
                        $filename = str_replace(' ', '_', $baseFilename).'.eps';
                        $zip->addFromString($filename, $epsContent);
                    }
                    break;

                default: // PNG case
                    foreach ($campaigns as $campaign) {
                        $pngFileName = str_replace(' ', '_', $campaign->qrcode);
                        $pngFilePath = public_path('storage/campaign/'.$project_name.'/'.$pngFileName);

                        if (file_exists($pngFilePath)) {
                            $zip->addFile($pngFilePath, $pngFileName);
                        } else {
                            // Log missing file or handle error
                            \Log::warning('PNG file not found: '.$pngFilePath);
                        }
                    }
                    break;
            }

            $zip->close();

            // Check if zip file was created successfully
            if (! file_exists($zipFilePath)) {
                return response()->json(['error' => 'Failed to create zip file'], 500);
            }

            return response()->download($zipFilePath)->deleteFileAfterSend();

        } catch (\Exception $e) {
            \Log::error('Multiple download error: '.$e->getMessage());

            return response()->json(['error' => 'Internal server error: '.$e->getMessage()], 500);
        }
    }

    public function update(Request $request, Campaign $campaign)
    {
        // dd($campaign);
        $this->validate($request, [
            'title' => 'required',
            'qr_type' => 'required',
            'status' => 'required',
        ]);
        if ($request->qr_type == 'url') {
            $target = $request->input('target_url');
        } else {
            $target = $request->input('target_code');
        }
        // $campaign->title = $request->input('title');
        // $campaign->type = $request->input('qr_type');
        // $campaign->target = $target;
        // $campaign->status = $request->input('status');
        // $campaign->save();

        if ($campaign->title !== $request->title) {
            // rename the file
            $project = Project::find($campaign->project_id);
            $file = 'public/campaign/'.str_replace(' ', '_', $project->name).'/'.str_replace(' ', '_', $campaign->qrcode);

            // check if file exists
            if (Storage::disk('local')->exists($file)) {
                $qrNewName = $request->title.'-'.date('dmY-h:i:s').'.png';
                $new_file = 'public/campaign/'.str_replace(' ', '_', $project->name).'/'.str_replace(' ', '_', $qrNewName);
                Storage::disk('local')->move($file, $new_file);
            }

            $updation = $campaign->update([
                'title' => $request->title,
                'type' => $request->qr_type,
                'qrcode' => $qrNewName ?? $campaign->qrcode,
                'status' => $request->status,
                'target' => $target,
            ]);
        } else {
            $updation = $campaign->update([
                'title' => $request->title,
                'type' => $request->qr_type,
                'status' => $request->status,
                'target' => $target,
            ]);
        }

        // if ($updation) {
        //     return response()->json([
        //         'message' => 'Campaign updated successfully',
        //         'status' => 'success',
        //     ]);
        // } else {
        //     return response()->json([
        //         'message' => 'Campaign not updated',
        //         'status' => 'error',
        //     ]);
        // }
        return back()->with('success', 'QR Code updated successfully');
    }

    public function destroy(Campaign $campaign)
    {
        $project = $campaign->project;
        $file = public_path().'/storage/campaign/'.str_replace(' ', '_', $project->name).'/'.str_replace(' ', '_', $campaign->qrcode);
        if (file_exists($file)) {
            unlink($file);
        }
        if ($campaign->delete()) {
            return back()->with('message', 'QR Code Deleted successfully');
        }

        return back()->with('error', 'QR Code deletion Failed');
    }

    public function archive(Campaign $campaign)
    {
        $campaign->archived = 1;
        if ($campaign->save()) {
            return back()->with('success', 'QR archived successfully');
        }

        return back()->with('error', 'QR archive Failed');
    }

    public function unarchive(Campaign $campaign)
    {
        $campaign->archived = 0;
        if ($campaign->save()) {
            return back()->with('success', 'QR removed from archive successfully');
        }

        return back()->with('error', 'QR unarchive Failed');
    }

    public function multiple_archive(Request $request)
    {
        $project_name = str_replace(' ', '_', $request->input('project'));
        $qrIDs = $request->input('qrIDs');
        $campaigns = Campaign::whereIn('id', $qrIDs)->get();
        $campaigns_count = count($campaigns);
        foreach ($campaigns as $campaign) {
            if ($campaign->archived == 0) {
                $campaign->archived = 1;
                $message = ' QRs Archived Successfully';
            } else {
                $campaign->archived = 0;
                $message = ' QRs Unarchived Successfully';
            }
            $campaign->save();
        }
        $request->session()->flash('success', $campaigns_count.$message);
        // return back();
    }

    // helper functions

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
