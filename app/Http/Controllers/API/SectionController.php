<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Section\SectionRequest;
use App\Http\Requests\Section\SectionUpdateRequest;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SectionController extends Controller
{
    /**
     * property user
     */
    private $section;

    /**
     * SectionController constructor.
     * Use the dependency injection mechanism for the Section model
     *
     * @param Section $section
     */
    public function __construct(Section $section)
    {
        $this->section = $section;
    }

    /**
     * Display a listing of the sections resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = $this->section->with('users:name')->paginate(4);
        return response()->json($sections);
    }

    /**
     * Store a newly created sections resource in storage.
     *
     * @param  SectionRequest   $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionRequest $request)
    {
        $section = new Section;

        $section->name = $request->name;
        $section->description = $request->description;
        $section->logo = $this->storeImage($request);

        $section->save();

        $section->users()->sync(json_decode($request->users));

        return response()->json('New section successfully created');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SectionUpdateRequest  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(SectionUpdateRequest $request, Section $section)
    {
        $section->name = $request->name;
        $section->description = $request->description;
        $section->logo = $this->storeImage($request);
        $section->save();

        $section->users()->sync(json_decode($request->users));

        return response()->json('Section updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section $section
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Section $section)
    {
        Storage::delete($section->logo);
        $section->delete();
        return response()->json(['success'=>'User deleted successfully.'], 204);
    }

    /**
     * Save image and return image path
     * @param $data
     * @return string
     */
    private function storeImage($data)
    {
        if ($data->hasFile('logo')) {
            $path = $data->file('logo')->store('logo');

            // make array from value path
            $imagePath = explode('/', $path);

            // make name image
            $imageName = end($imagePath);

            return $imageName;
        };

        return $data->logo;
    }

}
