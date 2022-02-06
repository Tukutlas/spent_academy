<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Helper\GeneralHelper;
use App\Services\InstructorService;

class Courses extends Controller
{
    protected $user;
    
    public function __construct(Request $request)
    {
        $this->user = GeneralHelper::getActiveUser($request);
    }

    public function createCourse(Request $request)
    {
        $rules = [
            'category'=> 'required|numeric',
            'title'=> 'required',
            'description'=> 'required',
            'price'=> 'required|numeric',
            'video'=> 'required',
            'difficulty'=> 'required'
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->respondWithErrorMessage($validator);
        }

        $create_course = CourseService::createCourse($request, $this->user);
        return $create_course;
    }

    public function getInstructorCourses(Request $request)
    {
        $courses = CourseService::getInstructorCourses($this->user->id);
        return $courses;
    }

    public function getCourse($id)
    {
        $course = CourseService::getInstructorSingleCourse($id, $this->user);
        return $course;
    }
}
