<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;

class CourseController extends Controller
{
    public function courseEnrollment(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'total_videos' => 'required',
        ]);

        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'total_videos' => $request->total_videos,
            'user_id' => auth()->id()
        ]);
        
        return response()->json([
            'status' => 1,
            'message' => 'Course enrolled successfully',
        ]);
    }

    public function totalCourses()
    {
        $courses = User::find(auth()->id())->courses;

        return response()->json([
            'status' => 1,
            'message' => 'Got all courses enrolled successfully',
            'data' => $courses
        ]);
    }

    public function deleteCourse($id)
    {
        if(Course::where(['id' => $id, 'user_id' => auth()->id()])->exists()){

            Course::destroy($id);

            return response()->json([
                'status' => 1,
                'message' => 'Course deleted successfully'
            ]);
        }else {

            return response()->json([
                'status' => 0,
                'message' => 'Course not found'
            ]);
        }
    } 


}
