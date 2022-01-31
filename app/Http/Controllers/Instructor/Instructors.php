<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Services\InstructorService;
use Illuminate\Http\Request;
use App\Helper\GeneralHelper;


class Instructors extends Controller
{
    protected $user;
    
    public function __construct(Request $request)
    {
        $this->user = GeneralHelper::getActiveUser($request);
    }

    public function getProfile()
    {
        $instructor_profile = InstructorService::getInstructorProfile($this->user);
        return $instructor_profile;
    }

    public function updateInstructorProfile(Request $request)
    {
        
    }



    
}