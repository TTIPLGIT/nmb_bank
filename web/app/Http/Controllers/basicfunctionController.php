

<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class common_function
{
    public function file_type($file_name)
    {
        $file_data = explode('.', $file_name);
        $file_type = $file_data[count($file_data) - 1];
        if ($file_type == 'pdf') {
            return "pdf";
        } elseif ($file_type == 'doc') {
            return "doc";
        } elseif ($file_type == 'png') {
            return "gallery";
        }
    }
    public function add_to_cart($course_id)
    {
        // $userID = auth()->user()->id;
        $userID = session()->get("userID");
        $count = DB::select("SELECT count(*) as total_count from elearning_cart where course_id=$course_id and user_id= $userID and active_flag=0");
        $is_payed = DB::select("SELECT * from elearning_payment_details where course_id=$course_id and user_id= $userID");
        if($is_payed !=[]){
            return 2;
        }
        if ($count[0]->total_count != 0) {
            return 1;
        } else {
            return 0;
        }
    }
    public function buy_to_take($course_id)
    {
        // $userID = auth()->user()->id;
        $userID = session()->get("userID");
        $count = DB::select("SELECT count(*) as total_count from elearning_payment_details where course_id=$course_id and user_id= $userID");
        
        if ($count[0]->total_count != 0) {
            return 1;
        } else {
            return 0;
        }
    }
}
