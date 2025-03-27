<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Course;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('course')->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('posts.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        Post::create($request->all());
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        $post->load('course');
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $courses = Course::all();
        return view('posts.edit', compact('post', 'courses'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        $post->update($request->all());
        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
