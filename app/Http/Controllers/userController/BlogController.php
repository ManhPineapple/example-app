<?php

namespace App\Http\Controllers\userController;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('author')->get();
        $blogs = $blogs->map(function ($blog) {
            $blog->author = $blog->author;
            return $blog;
        });

        return response()->json([
            'status' => 200,
            'message' => 'Blogs retrieved successfully',
            'data' => $blogs
        ]);
    }

    public function show($id)
    {
        $blog = Blog::find($id);
        return response()->json([
            'status' => 200,
            'message' => 'Blog retrieved successfully',
            'data' => $blog
        ]);
    }

    public function store(Request $request)
    {
        $blog = new Blog;
        $blog->author_id = $request->user()->id;
        $blog->title = $request->title;
        $blog->content = $request->content;
        if ($request->has('category_ids')) {
            foreach ($request->category_ids as $categoryId) {
                $category = BlogCategory::find($categoryId);
                if ($category) {
                    $blog->categories()->attach($category);
                }
            }
        }

        $blog->save();
        return response()->json([
            'status' => 200,
            'message' => 'Blog created successfully',
            'data' => $blog
        ]);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);
        if ($request->has('title')) {
            $blog->title = $request->title;
        }
        if ($request->has('content')) {
            $blog->content = $request->content;
        }
        $blog->save();
        return response()->json([
            'status' => 200,
            'message' => 'Blog updated successfully',
            'data' => $blog
        ]);
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);
        $blog->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Blog deleted successfully',
            'data' => null
        ]);
    }
}