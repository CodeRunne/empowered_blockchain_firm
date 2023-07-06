<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseCategory;
use App\Http\Resources\CourseCategoryResource;
use App\Http\Requests\StoreCourseCategoryRequest;
use App\Http\Requests\UpdateCourseCategoryRequest;

class CourseCategoryController extends Controller
{
    /**
     * Course Category
     *
     * @return   \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index() {
        return CourseCategoryResource::collection(CourseCategory::all());
    }

    public function show(CourseCategory $courseCategory) {
        return new CourseCategoryResource($courseCategory->loadMissing('courses'));
    }

    /**
     * Store course category
     * @param      \App\Http\Requests\StoreCourseCategoryRequest  $request  The request
     * @return     \Illuminate\Http\JsonResponse
     */
    public function store(StoreCourseCategoryRequest $request) {

        CourseCategory::create($request->validated());
        
        return response()->json([
            'message' => 'Course category successfully created'
        ]);

    }

    /**
     * Update Course Category
     * @param      \App\Http\Requests\UpdateCourseCategoryRequest  $request         
     * @param      \App\Models\CourseCategory                      $courseCategory
     * @return     \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCourseCategoryRequest $request, CourseCategory $courseCategory) {
        
        $courseCategory->update($request->validated());
        
        return response()->json([
            'message' => 'Course category successfully updated'
        ]);

    }

    /**
     * Deletes the given course category.
     * @param      \App\Models\CourseCategory  $courseCategory 
     * @return     \Illuminate\Http\JsonResponse
     */
    public function delete(CourseCategory $courseCategory) {
        
        $courseCategory->delete();
        
        return response()->json([
            'message' => 'Course category successfully deleted'
        ]);
    }
}
