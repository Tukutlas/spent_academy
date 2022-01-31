<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Helper\GeneralHelper;


class Instructors extends Controller
{
    protected $user;
    
    public function __construct(Request $request)
    {
        $this->user = GeneralHelper::getActiveUser($request);
    }

    public function updateInstructorProfile(Request $request)
    {
        
    }



    
}