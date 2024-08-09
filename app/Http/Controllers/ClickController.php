<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Click;
use App\Models\Campaign;
use Agent;
use Carbon\Carbon;
use App\Models\Goal;

class ClickController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    ///////////////////////////////
    //  Global Click
    ///////////////////////////////
    protected function globalClick($offerlink)
    {

        $campaign = Campaign::where('link', $offerlink)->first();

        if (!$campaign) {
            return response('Failed');
        }

        //
        $ip = $this->getIp();
        $device_data = $this->getDeviceinfo();

        /****************/

        $data = [
            'campaign_id'       => $campaign->id,
            'ip_address'        => $ip,
            //'location'          => $location,
            'device'            => $device_data['device'],
            'os'                => $device_data['os'],
            'os_version'        => $device_data['os_version'],
            'browser'           => $device_data['browser'],
            'browser_version'   => $device_data['browser_version'],
        ];

        $click = Click::create($data);

        if ($click) {
            if ($campaign->type == 'url') {
                return view('redirection', ['campaign' => $campaign]);
                // return redirect()->to($campaign->target);
            } elseif ($campaign->target && $campaign->type == 'code') {
                return response($campaign->target);
            }
        } else {
            return response('Target not found');
        }
    }

    //
    public function getIp()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }


    /*
    * Get Device info
    */
    public function getDeviceinfo()
    {
        $device_info = array();

        $device_info['os'] = Agent::platform();
        $device_info['os_version'] = Agent::version($device_info['os']);

        $device_info['browser'] = Agent::browser();
        $device_info['browser_version'] = Agent::version($device_info['browser']);

        if (Agent::isMobile()) {
            $device = 'mobile';
        } elseif (Agent::isDesktop()) {
            $device = 'desktop';
        } elseif (Agent::isTablet()) {
            $device = 'tablet';
        } else {
            $device = '';
        }

        $device_info['device'] = $device;

        return $device_info;
    }
}
