<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Helper\GeneralHelper;

class courses extends Controller
{
    protected $user;
    
    public function __construct(Request $request)
    {
        $this->user = GeneralHelper::getActiveUser($request);
    }

    public function createCourse(Request $request)
    {
        $create_course = CourseService::createCourse($request, $this->user);
        return $create_course;
    }
}
