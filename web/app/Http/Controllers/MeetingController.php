<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use App\Mail\ZoomMeetingMail;
use Illuminate\Support\Facades\Http;
use DB;

class MeetingController extends BaseController
{
    public function meeting_list(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $user_id = $request->session()->get("userID");
        $method = 'Method => MeetingController => meeting_list';


        $gatewayURL = config('setting.api_gateway_url') . '/meeting/list';
        $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

        $response = json_decode($response);

        if ($response->Status == 200 && $response->Success) {
            $objData = json_decode($this->decryptData($response->Data));
            if ($objData->Code == 200) {
                $parant_data = json_decode(json_encode($objData->Data), true);
                $rows =  $parant_data;
                $alter_name = $this->get_user_role();
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                $permission = $this->FillScreensByUser();

                return view('VirtualMeeting.meeting_list', compact('rows', 'menus', 'screens', 'modules'));
            }
            if ($objData->Code == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
        }
    }
    public function virtual_meeting(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $user_id = $request->session()->get("userID");
        $method = 'Method => MeetingController => create';


        $gatewayURL = config('setting.api_gateway_url') . '/meeting/create';
        $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

        $response = json_decode($response);

        if ($response->Status == 200 && $response->Success) {
            $objData = json_decode($this->decryptData($response->Data));
            if ($objData->Code == 200) {
                $parant_data = json_decode(json_encode($objData->Data), true);
                $rows =  $parant_data;
                $alter_name = $this->get_user_role();
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                $permission = $this->FillScreensByUser();

                return view('VirtualMeeting.meeting_create', compact('rows', 'menus', 'screens', 'modules'));
            }
            if ($objData->Code == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
        }
    }

    private function getZoomToken()
    {
        $ZOOM_CLIENT_ID = config('setting.zoom.client_id');
        $ZOOM_CLIENT_SECRET = config('setting.zoom.client_secret');
        $ZOOM_ACCOUNT_ID = config('setting.zoom.account_id');
        $response = Http::withBasicAuth(
            $ZOOM_CLIENT_ID,
            $ZOOM_CLIENT_SECRET
        )->asForm()->post('https://zoom.us/oauth/token', [
            'grant_type' => 'account_credentials',
            'account_id' => $ZOOM_ACCOUNT_ID,
        ]);

        if (!$response->successful()) {
            Log::error('Zoom Token Error', $response->json());
            throw new \Exception('Unable to generate Zoom access token');
        }
        $data = $response->json();

        if (!isset($data['access_token'])) {
            Log::error('Zoom Invalid Response', $data);
            throw new \Exception('Zoom access token not found');
        }

        return $data['access_token'];
    }


    public function meeting_store(Request $request)
    {
        $token = $this->getZoomToken();
        $startTime = $request->meeting_date . 'T' . $request->start_time . ':00';
        $meeting = Http::withToken($token)->post(
            "https://api.zoom.us/v2/users/me/meetings",
            [
                "topic" => $request->meeting_title,
                "type" => 2,
                "start_time" => $request->start_time,
                "duration" => $request->duration,
                "agenda" => $request->meeting_description,
            ]
        );

        $zoomData = $meeting->json();
        $meetingId = DB::table('virtual_meeting')->insertGetId([
            'course_id' => $request->course_id,
            'meeting_title' => $request->meeting_title,
            'meeting_description' => $request->meeting_description,
            'meeting_date' => $request->meeting_date,
            'start_time' => $request->start_time,
            'duration' => $request->duration,
            'platform' => 'zoom',
            'zoom_meeting_id' => $zoomData['id'],
            'join_url' => $zoomData['join_url'],
            'start_url' => $zoomData['start_url'],
            'host_email' => $zoomData['host_email'],
            'topic' => $zoomData['topic'],
            'status' => $zoomData['status'],
            'created_at' => now()
        ]);
        $course = DB::table('elearning_courses')
            ->where('course_id', $request->course_id)
            ->select('user_ids', 'course_name')
            ->first();

        if (!$course || empty($course->user_ids)) {
            return redirect()->back()->with('error', 'No users assigned to this course');
        }

        $userIds = explode(',', $course->user_ids);
        $users = DB::table('users')
            ->whereIn('id', $userIds)->get();
        foreach ($users as $user) {
            Mail::to($user->email)->send(
                new ZoomMeetingMail($zoomData)
            );
        }



        return redirect()->back()->with('success', 'Meeting created successfully');
    }
}
