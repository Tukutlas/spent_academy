<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Helper\GeneralHelper;

class Courses extends Controller
{
    protected $user;
    
    public function __construct(Request $request)
    {
        $this->user = GeneralHelper::getActiveUser($request);
    }

    public function createCourseCategory(Request $request)
    {
        $rules = [
            'title'=> 'required'
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->respondWithErrorMessage($validator);
        }

        $create_category = CourseService::createCourseCategory($request);
        return $create_category;
    }

    public function getCourseCategories()
    {
        $categories = CourseService::getCourseCategories();
        return $categories;
    }

    public function createCourseSubcategory(Request $request)
    {
        $rules = [
            'category' => 'required|numeric',
            'title'=> 'required'
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->respondWithErrorMessage($validator);
        }

        $create_subcategory = CourseService::createCourseSubcategory($request);
        return $create_subcategory;
    }

    public function getCourseSubcategories()
    {
        $subcategories = CourseService::getCourseSubcategories();
        return $subcategories;
    }

    public function getCourseSubcategoriesByCategory($id)
    {
        $subcategories = CourseService::getCourseSubcategoriesByCategory($id);
        return $subcategories;
    }

}
