<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Resources\CourseResource;
use App\Http\Requests\StoreCoursesRequest;
use App\Http\Requests\UpdateCoursesRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $courses = request()->has(['page', 'limit']) ?

            Course::selectLatest()->get()->forPage(request('page'), request('limit')) :

            Course::selectLatest()->orderBy('id')->get();

        return CourseResource::collection($courses);      
    }

    /**
     * Store a newly created resource in storage.
     * @param App\Http\Requests\StoreCoursesRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCoursesRequest $request)
    {
        $attributes = $request->validated();
        Course::create([
            'user_id' => request()->user->id,
            'course_category_id' => request()->course_category,
            'title' => $attributes['title'],
            'slug' => $attributes['slug'],
            'description' => $attributes['description'],
            'thumbnail' => $attributes['thumbnail'],
            'body' => $attributes['body'],
        ]);

        return response()->json([
            'message' => 'Course successfully created'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return new CourseResource($course);
    }

    /**
     * Update the specified resource in storage.
     * @param App\Http\Requests\UpdateCoursesRequest $request
     * @param App\Models\Course $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCoursesRequest $request, Course $course)
    {

        $course->update($request->validated());

        return response()->json([
            'message' => 'Course updated updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param App\Models\Course $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json([
            'message' => 'Course successfully deleted'
        ]);
    }

    public function tmpUpload(Request $request): string {
        if($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $fileName = $image->getClientOriginalName();
            $folder = uniqid('courses', true);
            $image->storeAs('courses/tmp/'.$folder, $fileName);

            TemporaryFile::create([
                'folder' => $folder,
                'file' => $fileName
            ]);
            return $folder;
        }
        return '';
    }

    public function tmpDelete() {
        $tmpFile = TemporaryFile::where('folder', request()->getContent())->first();
        if($tmpFile) {
            Storage::deleteDirectory('courses/tmp/'. $tmpFile->folder);
            $tmpFile->delete();
            return response('');
        }
    }
}