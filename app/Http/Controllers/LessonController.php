<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::with('section')->get();
        return view('lessons.index', compact('lessons'));
    }

    public function create()
    {
        $sections = Section::all();
        return view('lessons.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'required',
            'type' => 'required',
            'content' => 'nullable',
            'file_url' => 'nullable',
        ]);

        Lesson::create($request->all());
        return redirect()->route('lessons.index')->with('success', 'Lesson created successfully.');
    }

    public function show(Lesson $lesson)
    {
        $lesson->load('section', 'quizzes');
        return view('lessons.show', compact('lesson'));
    }

    public function edit(Lesson $lesson)
    {
        $sections = Section::all();
        return view('lessons.edit', compact('lesson', 'sections'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'required',
            'type' => 'required',
            'content' => 'nullable',
            'file_url' => 'nullable',
        ]);

        $lesson->update($request->all());
        return redirect()->route('lessons.index')->with('success', 'Lesson updated successfully.');
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('lessons.index')->with('success', 'Lesson deleted successfully.');
    }
}
