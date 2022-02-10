<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;


class StudentService
{
    public static function getAllStudents($perpage)
    {
        $students = User::where('user_type', 1)->orderBy('id', 'desc')->paginate($perpage);
        
        return response()->json([
            'status' => true,
            'data' => $students
        ]);

    }

    public static function getStudentCourses($perpage,$user)
    {
        $courses = 
    }
}