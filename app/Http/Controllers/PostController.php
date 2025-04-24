<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Course;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $title = 'Quản lí bài viết';
        $posts = Post::with('course')->paginate(10); 
        return view('admin.posts.index', compact('posts', 'title'));
    }
    

    public function create()
    {
        $title = 'Tạo bài viết';
        $courses = Course::all();
        return view('admin.posts.create', compact('courses', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        Post::create($request->all());
        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        $title = 'Chi tiết bài viết';
        $post->load('course');
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $title = 'Sửa bài viết';
        $courses = Course::all();
        return view('admin.posts.edit', compact('post', 'courses'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'course_id' => 'required|exists:courses,id',
        ]);

        $post->update($request->all());
        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }
    public function list()
    {
        $title = 'Danh sách bài viết';
        $posts = Post::with('course')->paginate(10); 
        return view('post.index', compact('posts', 'title'));
    }
    
    public function showForUser($id)
    {
        // $title = $post->title;
        $post = Post::with('course')->findOrFail($id);
        
        // Lấy các bài viết khác thuộc cùng khóa học
        $relatedPosts = Post::where('course_id', $post->course_id)
                            ->where('id', '!=', $post->id)
                            ->latest()
                            ->take(5)
                            ->get();
    
        return view('post.viewpost', compact('post', 'relatedPosts'));
    }
    
}
