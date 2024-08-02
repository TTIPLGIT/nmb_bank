<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class course extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'elearning_courses';
    protected $fillable = [
        'course_id',
        'course_banner',
        'course_name',
        'course_instructor',
        'course_start_period',
        'course_end_period',
        'course_pay',
        'course_price',
        'course_description',
        'course_introduction',
        'course_tags',
        'course_skills_required',
        'course_gain_skills',
        'course_classes',
        'course_bonus',
        'drop_course'
    ];
    public static function getCourseprogressbar($user_id)
    {
        $results = DB::select("SELECT * FROM elearning_courses as ec inner join user_course_relation as uc on ec.course_id=uc.course_id where uc.user_id=$user_id");

        // $results= DB::table('elearning_courses')
        //     ->join('user_course_relation', 'user_course_relation.course_id', '=', 'elearning_courses.course_id')
        //     ->select('elearning_courses.*', 'user_course_relation.user_id')
        //     ->where('user_course_relation.user_id', '=', $user_id)
        //     ->get();

        $courseProgress = [];
        foreach ($results as $result) {
            $courseProgress[$result->course_id] = $result;

        }
        return $courseProgress;
        // $is_completed = DB::select("SELECT COUNT(*) as total_completed_classes FROM user_class_relation WHERE status = 1");

        // if (!empty($is_completed)) {
        //     $totalCompletedClasses = $is_completed[0]->total_completed_classes;
           
        //     $courseId = $courseProgress[$result->course_id]->course_id;
            
        //     // Get the total number of classes for the course
        //     $totalclasses = DB::select("SELECT course_classes FROM elearning_courses WHERE course_id = $courseId");
            
        //     // 
        //     $totalClasses = (int) $totalclasses;
            
        //     $totalClassesCompleted = (int) $totalCompletedClasses;
        //    // dd( $totalClassesCompleted);
        //     $progressPercentage = ($totalClassesCompleted / $totalClasses) * 100;
        //     dd( $progressPercentage);
        //     // Calculate the progress percentage
        //     // $progressPercentage = ($totalCompletedClasses / $totalClasses) * 100;

        //     // Update the progress percentage in the database or use it as needed
        //     // ...
            

        // }
    }
}
