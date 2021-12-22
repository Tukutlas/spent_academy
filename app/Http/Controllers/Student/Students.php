<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Services\StudentService;
use Illuminate\Http\Request;



class Students extends Controller
{
    protected $user;
    
    public function __construct(Request $request)
    {
        $this->user = GeneralHelper::getActiveUser($request);
    }

    
    public function all(Request $request)
    {
        $perpage = 10;
        if($request->perpage) {
            $perpage = $request->perpage;
        }

        $students = StudentService::getAllStudents($perpage);
        return $students;
    }
}