<?php

namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Get sections page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('sections.index');
    }

    /**
     * Show the form for creating section
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $users = User::all();
        return view('sections.create', compact('users'));
    }


    /**
     * Show the form for editing section.
     *
     * @param $language
     * @param  Section $section
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Section $section)
    {
        $sectionUsers = $section->users()->pluck('users.id');
        $users = User::select('id', 'name')->get();
        return view('sections.update', ['section' => $section, 'sectionUsers' => $sectionUsers, 'users' => $users]);
    }
}
