<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Helper\GeneralHelper;
use App\Models\Module;
use App\Models\Topic;
use App\Models\CourseCategory;
use App\Models\CourseSubcategory;
use App\Models\UserCourse;

class CourseService
{
    public static function createCourseCategory($request)
    {
        $category = new CourseCategory;
        $category->title = $request->title;
        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'course category created successfully'
        ]);
        
    }

    public static function getCourseCategories()
    {
        $categories = CourseCategory::all();
        return response()->json([
            'status' => true,
            'data' => $categories
        ]);
    }

    public static function createCourseSubcategory($request)
    {
        $subcategory = new CourseSubcategory;
        $subcategory->category_id = $request->category;
        $subcategory->title = $request->title;
        $subcategory->save();

        return response()->json([
            'status' => true,
            'message' => 'course subcategory created successfully'
        ]);
        
    }

    public static function getCourseSubcategories()
    {
        $subcategories = CourseSubcategory::all();
        return response()->json([
            'status' => true,
            'data' => $subcategories
        ]);
    }

    public static function getCourseSubcategoriesByCategory($id)
    {
        $subcategories = CourseSubcategory::where('category_id', $id)->get();
        return response()->json([
            'status' => true,
            'data' => $subcategories
        ]);
    }

    public static function createCourse($request, $user)
    {
        $course = new Course;
        $course->category_id = $request->category;
        $course->subcategory_id = $request->subcategory;
        $course->title = $request->title;
        $course->description = $request->description;
        $course->price = $request->price;
        $course->status = "inactive";
        $course->approval_status = "pending";

        $file = "";

        if ($request->hasFile('image')) {
            $file = GeneralHelper::uploadFile($request->file('image'));
            $course->image = $file;
        }

        $video_file = "";

        if ($request->hasFile('video')) {
            $video_file = GeneralHelper::uploadFile($request->file('image'));
            $course->video = $video_file;
        }
        
        $course->difficulty = $request->difficulty;
        $course->created_by = $user->id;
        $course->save();

        return response()->json([
            'status' => true,
            'message' => 'course created successfully'
        ]);
        
    }

    public static function validateCourseExistense($id)
    {
        $course = Course::where('id', $id)->first();
        throw_if(
            !$course,
            new \InvalidArgumentException('Course doesn\'t exist.')
        );

        return $course;
    }

    public static function getAllCourses($perpage)
    {
        $courses = Course::orderBy('id', 'desc')->paginate($perpage);
        
        return response()->json([
            'status' => true,
            'data' => $courses
        ]);
    }

    public static function getAllActiveCourses($perpage)
    {
        $courses = Course::where('status', 'active')->where('approval_status', 'approved')->orderBy('id', 'desc')->paginate($perpage);
        
        return response()->json([
            'status' => true,
            'data' => $courses
        ]);
    }

    public static function getCourse($id)
    {
        $course = self::validateCourseExistense($id);
        return $course;
    }

    public static function getAllApprovedCourses($perpage)
    {
        $courses = Course::where('approval_status', 'approved')->orderBy('id', 'desc')->paginate($perpage);
        
        return response()->json([
            'status' => true,
            'data' => $courses
        ]);
    }

    public static function courseApproval($id, $user, $request)
    {
        $course = self::validateCourseExistense($id);
        if ($request->approval_status == "approve") {
            $course->approval_status = "approved";
            $course->status = "active";
        }elseif ($request->approval_status == "disapprove") {
            $course->approval_status = "disapproved";
            $course->status = "inactive";
        }
        
        $course->approval_by = $user->id;
        $course->updated_by = $user->id;
        $course->save();

        return response()->json([
            'status' => true,
            'message' => 'Course has been approved'
        ]);
    }

    public static function courseActivation($id, $user, $request)
    {
        $course = self::validateCourseExistense($id);
        if ($request->approval_status == "approve") {
            $course->status = "active";
        }elseif ($request->approval_status == "disapprove") {
            $course->status = "inactive";
        }
        
        $course->updated_by = $user->id;
        $course->save();

        return response()->json([
            'status' => true,
            'message' => 'course has been activated'
        ]);
    }

    public static function addCourseModules($id, $user, $request)
    {
        $module = new Module;
        $module->course_id = $id;
        $module->name = $request->name;
        $module->description = $request->description;
        $module->created_by = $user->id;
        $module->save();

        return response()->json([
            'status' => true,
            'data' => $module
        ]);
    }

    public static function addCourseTopics($id, $module_id, $user, Request $request)
    {
        $course = self::validateCourseExistense($id);

        $file = "";

        if ($request->hasFile('video')) {
            $file = GeneralHelper::uploadFile($request->file('video'));
        }

        $topic = new Topic;
        $topic->course_id = $id;
        $topic->module_id = $module_id;
        $topic->title = $request->title;
        $topic->video = $file;
        $topic->created_by = $user->id;
        $topic->save();

        return response()->json([
            'status' => true,
            'data' => $topic
        ]);
    }

    public static function getCourseTopics($id)
    {
        $course = self::validateCourseExistense($id);
        $course_topics = Topic::where('course_id', $id)->get();
        
        $data = [
            'course'=> $course,
            'course_topics' => $course_topics
        ];
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public static function getInstructorCourses($id)
    {
        $instructor_courses = Course::where('created_by', $id)->get();
        return $instructor_courses;
    }

    public static function getInstructorSingleCourse($id, $user)
    {
        $instructor_course = Course::where('id', $id)->where('created_by', $user->id)->get();
        return $instructor_course;
    }

    public static function getStudentCourses($perpage, $user)
    {
        $user_courses = UserCourse::where('user_id', $user->id)
        ->orderBy('id','desc')->paginate($perpage);
    
        $remapped = $user_courses->getCollection()->transform(function ($item) {
            $course = Course::where('id', $item->course_id)->first();
            $item->title = $course->title;
            $item->image = $course->image;
            return $item;
        });
    
        $data = ['expense_types' => $user_courses->setCollection($remapped)];
        
        return response()->json([
            'status' => true,
            'data' => $data    
        ]);
    }
}

