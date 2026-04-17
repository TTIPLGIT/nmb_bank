<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use App\Mail\ZoomMeetingMail;
use Illuminate\Support\Facades\Http;
use DB;
use App\Mail\MeetingStatusUpdateMail;

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
    $request->validate([
        'course_id' => 'required',
        'meeting_title' => 'required',
        'meeting_date' => 'required',
        'start_time' => 'required',
        'duration' => 'required',
        'platform' => 'required'
    ]);
    
    $joinUrl = null;
    $zoomData = null;
    
    // Handle Zoom meetings
    if ($request->platform == 'zoom') {
        $token = $this->getZoomToken();
        $startTime = $request->meeting_date . 'T' . $request->start_time . ':00';
        
        $meeting = Http::withToken($token)->post(
            "https://api.zoom.us/v2/users/me/meetings",
            [
                "topic" => $request->meeting_title,
                "type" => 2,
                "start_time" => $startTime,
                "duration" => (int)$request->duration,
                "agenda" => $request->meeting_description,
                "timezone" => "Asia/Kolkata"
            ]
        );
        
        if (!$meeting->successful()) {
            \Log::error('Zoom API Error', $meeting->json());
            return redirect()->back()->with('error', 'Failed to create Zoom meeting: ' . ($meeting->json()['message'] ?? 'Unknown error'));
        }
        
        $zoomData = $meeting->json();
        $joinUrl = $zoomData['join_url'];
    } 
    // Handle Teams and Google Meet with custom link
    else {
        if (empty($request->custom_link)) {
            return redirect()->back()->with('error', 'Meeting link is required for ' . ucfirst($request->platform));
        }
        $joinUrl = $request->custom_link;
    }
    
    $meetingId = DB::table('virtual_meeting')->insertGetId([
        'course_id' => $request->course_id,
        'meeting_title' => $request->meeting_title,
        'meeting_description' => $request->meeting_description,
        'meeting_date' => $request->meeting_date,
        'start_time' => $request->start_time,
        'duration' => $request->duration,
        'platform' => $request->platform,
        'zoom_meeting_id' => $zoomData['id'] ?? null,
        'join_url' => $joinUrl,
        'start_url' => $zoomData['start_url'] ?? null,
        'host_email' => $zoomData['host_email'] ?? null,
        'topic' => $request->meeting_title,
        'status' => 'scheduled',
       
        'created_at' => now()
    ]);
    
    // Get course participants and send email
    $course = DB::table('elearning_courses')
        ->where('course_id', $request->course_id)
        ->select('user_ids', 'course_name')
        ->first();
    
    if (!$course || empty($course->user_ids)) {
        return redirect()->back()->with('error', 'No users assigned to this course');
    }
    
    $userIds = explode(',', $course->user_ids);
    $users = DB::table('users')
        ->whereIn('id', $userIds)
        ->get();
    
    $meetingDetails = (object)[
        'id' => $meetingId, 
        'topic' => $request->meeting_title,
        'join_url' => $joinUrl,
        'start_time' => $request->start_time,
        'meeting_date' => $request->meeting_date,
        'duration' => $request->duration,
        'platform' => $request->platform,
        'agenda' => $request->meeting_description
    ];
    
    foreach ($users as $user) {
        
        try {
            
            Mail::to($user->email)->send(new ZoomMeetingMail($meetingDetails));
            $this->notifications_insert(null, $user->id, "A new meeting '{$meetingDetails->topic}' has been scheduled for you.", "/elearningquestion");
        } catch (\Exception $e) {
            \Log::error('Email sending failed for user ' . $user->id . ': ' . $e->getMessage());
        }
    }
    
    return redirect()->route('meeting_list')->with('success', 'Meeting created successfully and notifications sent to participants');
}
    public function meeting_update_status(Request $request)
{
    $user_id = $request->session()->get("userID");
    if ($user_id == null) {
        return view('auth.login');
    }
    
    $request->validate([
        'meeting_id' => 'required',
        'status' => 'required|in:scheduled,completed,cancelled,rescheduled',
        'notes' => 'required|string|min:5'
    ]);
    
    try {
        // Update meeting status in database
        
        DB::table('virtual_meeting')
            ->where('id', $request->meeting_id)
            ->update([
                'status' => $request->status,
                'status_notes' => $request->notes,
                'status_updated_at' => now(),
                'status_updated_by' => $user_id
            ]);
        
        // If status is cancelled or rescheduled, you might want to notify participants
        if (in_array($request->status, ['cancelled', 'rescheduled'])) {
            // Get meeting details
            $meeting = DB::table('virtual_meeting')
                ->where('id', $request->meeting_id)
                ->first();
            
            if ($meeting) {
                // Get course participants
                $course = DB::table('elearning_courses')
                    ->where('course_id', $meeting->course_id)
                    ->first();
                
                if ($course && !empty($course->user_ids)) {
                    $userIds = explode(',', $course->user_ids);
                    $users = DB::table('users')
                        ->whereIn('id', $userIds)
                        ->get();
                    
                    // Send email notification about status change
                    foreach ($users as $user) {
                        // You can create a new Mailable class for status updates
                        Mail::to($user->email)->send(new MeetingStatusUpdateMail($meeting, $request->status, $request->notes));
                        $this->notifications_insert(null, $user->id, "{$meeting->topic} meeting status has been updated.", "/elearningquestion");
                    }
                }
            }
        }
        
        return redirect()->back()->with('success', 'Meeting status updated successfully');
        
    } catch (\Exception $e) {
        
        return redirect()->back()->with('error', 'Failed to update meeting status: ' . $e->getMessage());
    }
}
public function myMeetings(Request $request)
{
    $user_id = $request->session()->get("userID");
    if ($user_id == null) {
        return view('auth.login');
    }
    
    try {
        // Get courses where user is enrolled
        $userCourses = DB::table('elearning_courses')
            ->whereRaw("FIND_IN_SET(?, user_ids)", [$user_id])
            ->pluck('course_id');
        
        if ($userCourses->isEmpty()) {
            $meetings = collect();
        } else {
            // Get meetings for user's courses
            $meetings = DB::table('virtual_meeting')
                ->whereIn('course_id', $userCourses)
                ->orderBy('meeting_date', 'desc')
                ->orderBy('start_time', 'desc')
                ->get();
        }
        
        // Get upcoming meetings (future dates)
        $upcomingMeetings = DB::table('virtual_meeting')
            ->whereIn('course_id', $userCourses)
            ->where('meeting_date', '>=', date('Y-m-d'))
            ->where('status', 'scheduled')
            ->orderBy('meeting_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();
        
        // Get past meetings
        $pastMeetings = DB::table('virtual_meeting')
            ->whereIn('course_id', $userCourses)
            ->where('meeting_date', '<', date('Y-m-d'))
            ->orWhere('status', 'completed')
            ->orderBy('meeting_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();
        
        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        
        return view('VirtualMeeting.my_meetings', compact('meetings', 'upcomingMeetings', 'pastMeetings', 'menus', 'screens', 'modules'));
        
    } catch (\Exception $e) {
        \Log::error('Error fetching user meetings: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to load meetings: ' . $e->getMessage());
    }
}
}