<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Admin functions
    public function index()
    {
        $title = 'Quản lí khóa học';
        $courses = Course::with('user', 'category')->get();
        return view('admin.course.index', compact('courses', 'title'));
    }


    public function create()
    {
        $title = 'Tạo khóa học';
        $users = User::all();
        $categories = Category::all();
        return view('admin.course.create', compact('users', 'categories', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif',
            'price' => 'required|numeric',
            'categories_id' => 'required|exists:categories,id',
        ]);

        $thumbnailPath = $request->file('thumbnail') ? $request->file('thumbnail')->store('courses', 'public') : null;

        $isFree = $request->has('is_free');
        
        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'thumbnail' => $thumbnailPath,
            'price' => $isFree ? 0 : $request->price,
            'categories_id' => $request->categories_id,
            'is_free' => $isFree,
        ]);
        
        // Chuyển hướng dựa trên loại khóa học
        if ($isFree) {
            return redirect()->route('admin.course.free')->with('success', 'Khóa học miễn phí đã được tạo thành công.');
        } else {
            return redirect()->route('admin.course.index')->with('success', 'Khóa học đã được tạo thành công.');
        }
    }

    public function show(Course $course)
    {
        $course->load('user', 'category', 'sections', 'posts', 'reviews');
        return view('admin.course.show', compact('course'));
    }

    public function edit($id)
    {
        $title = 'Sửa khóa học';
        $users = User::all();
        $course = Course::findOrFail($id);
        $categories = Category::all();
        return view('admin.course.edit', compact('course', 'users', 'categories', 'title'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'price' => 'required|numeric',
            'categories_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::delete('public/' . $course->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('courses', 'public');
            $course->thumbnail = $thumbnailPath;
        }

        $isFree = $request->price == 0;
        
        // Nếu đang chuyển từ có giá sang miễn phí, lưu giá gốc
        if ($isFree && $course->price > 0) {
            $course->original_price = $course->price;
        }
        
        // Nếu đang chuyển từ miễn phí sang có giá, kiểm tra xem có giá gốc không
        if (!$isFree && $course->is_free && $course->original_price > 0) {
            $course->price = $request->price > 0 ? $request->price : $course->original_price;
        } else {
            $course->price = $request->price;
        }

        $course->title = $request->title;
        $course->description = $request->description;
        $course->categories_id = $request->categories_id;
        $course->is_free = $isFree;
        $course->save();

        return redirect()->route('admin.course.index')->with('success', 'Khóa học đã được cập nhật thành công.');
    }

    public function delete($id)
    {
        $course = Course::findOrFail($id);
        if ($course->thumbnail) {
            Storage::delete('public/' . $course->thumbnail);
        }
        $course->delete();
        return redirect()->route('admin.course.index')->with('success', 'Course deleted successfully.');
    }

    // Teacher functions
    public function indexTeacher()
    {
        $title = 'Quản lí khóa học';
        $query = Course::where('user_id', Auth::id())->with('user', 'category');
        
        if (request()->has('search')) {
            $searchTerm = request('search');
            $query->where('title', 'like', '%' . $searchTerm . '%');
        }

        $sort = request('sort', 'newest');
        switch ($sort) {
            case 'a-z';
                $query->orderBy('title', 'asc');
                break;
            case 'z-a';
                $query->orderBy('title', 'desc');
                break;
            case 'price-asc';
                $query->orderBy('price', 'asc');
                break;
            case 'price-desc';
                $query->orderBy('price', 'desc');
                break;
            case 'newest';
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest';
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $courses = $query->get();
        return view('teacher.course.index', compact('courses', 'title', 'sort'));
    }

    public function createTeacher()
    {
        $title = 'Tạo khóa học';
        $categories = Category::all();
        return view('teacher.course.create', compact('categories', 'title'));
    }

    public function storeTeacher(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'price' => 'required|numeric',
            'categories_id' => 'required|exists:categories,id',
        ]);

        $thumbnailPath = $request->file('thumbnail') ? $request->file('thumbnail')->store('courses', 'public') : null;

        $isFree = $request->has('is_free');

        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'thumbnail' => $thumbnailPath,
            'price' => $request->price,
            'categories_id' => $request->categories_id,
            'is_free' => $request->price == 0 ? true : false,
        ]);

        // Chuyển hướng dựa trên loại khóa học
        if ($isFree) {
            return redirect()->route('teacher.course.free')->with('success', 'Khóa học miễn phí đã được tạo thành công.');
        } else {
            return redirect()->route('teacher.course.index')->with('success', 'Khóa học đã được tạo thành công.');
        }
    }

    public function editTeacher($id)
    {
        $title = 'Sửa khóa học';
        $course = Course::where('user_id', Auth::id())->findOrFail($id); // Chỉ cho phép chỉnh sửa khóa học của teacher
        $categories = Category::all();
        return view('teacher.course.edit', compact('course', 'categories', 'title'));
    }

    public function updateTeacher(Request $request, $id)
    {
        $course = Course::where('user_id', Auth::id())->findOrFail($id); // Chỉ cho phép cập nhật khóa học của teacher
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'price' => 'required|numeric',
            'categories_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::delete('public/' . $course->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('courses', 'public');
            $course->thumbnail = $thumbnailPath;
        }
        $isFree = $request->price == 0;
        
        // Nếu đang chuyển từ có giá sang miễn phí, lưu giá gốc
        if ($isFree && $course->price > 0) {
            $course->original_price = $course->price;
        }
        
        // Nếu đang chuyển từ miễn phí sang có giá, kiểm tra xem có giá gốc không
        if (!$isFree && $course->is_free && $course->original_price > 0) {
            $course->price = $request->price > 0 ? $request->price : $course->original_price;
        } else {
            $course->price = $request->price;
        }

        $course->title = $request->title;
        $course->description = $request->description;
        $course->categories_id = $request->categories_id;
        $course->is_free = $isFree;
        $course->save();

        return redirect()->route('teacher.course.index')->with('success', 'Khóa học đã được cập nhật thành công.');
    }

    public function deleteTeacher($id)
    {
        $course = Course::where('user_id', Auth::id())->findOrFail($id); 
        if ($course->thumbnail) {
            Storage::delete('public/' . $course->thumbnail);
        }
        $course->delete();
        return redirect()->route('teacher.course.index')->with('success', 'Khóa học đã được xóa thành công.');
    }

    public function freeCoursesTeacher(Request $request)
    {
        $title = 'Danh sách khóa học miễn phí';
        
        $query = Course::where('is_free', true)->with('user', 'category');
        
        if ($request->has('user_id') && !empty($request->user_id)) {
            $query->where('user_id', $request->user_id);
            
            $user = User::find($request->user_id);
            if ($user) {
                $title = 'Danh sách khóa học miễn phí của ' . $user->username;
            }
        }
        
        $teachers = User::whereHas('courses', function($query) {
            $query->where('is_free', true);
        })->select('id', 'username', 'email')->get();
        
        $courses = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('teacher.course.free', compact('courses', 'title', 'teachers'));
    }
    
    public function favoriteCourses()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem danh sách yêu thích');
        }

        $courses = $user->favoriteCourses()->paginate(9);

        return view('favorites', compact('courses'));
    }

    public function freeCourses()
    {
        $title = 'Danh sách khóa học miễn phí';
        $courses = Course::where('is_free', true)
                        ->with('user', 'category')
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        return view('admin.course.free', compact('courses', 'title'));
    }
}