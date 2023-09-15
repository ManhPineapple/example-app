<?php

namespace App\Http\Controllers\userController;

use Illuminate\Http\Request;
use App\Repository\BlogEloquent;

class BlogController extends Controller
{
    protected $blogRepository;

    public function __construct(BlogEloquent $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function getAllBlogs()
    {
        $blogs = $this->blogRepository->getAllBlogs();

        return response()->json([
            'status' => 200,
            'message' => 'Blogs retrieved successfully',
            'data' => $blogs
        ]);
    }

    public function getBlogInfo($id)
    {
        $blog = $this->blogRepository->getBlogById($id);

        return response()->json([
            'status' => 200,
            'message' => 'Blog retrieved successfully',
            'data' => $blog
        ]);
    }

    public function createBlog(Request $request)
    {
        $userId = auth()->user()->id;
        $requestData = array_merge($request->all(), ['user_id' => $userId]);
        $blog = $this->blogRepository->createBlog($requestData);

        return response()->json([
            'status' => 200,
            'message' => 'Blog created successfully',
            'data' => $blog
        ]);
    }

    public function updateBlog(Request $request, $id)
    {
        $blog = $this->blogRepository->updateBlog($id, array_merge($request->all(), ['userId' => $request->user()->id]));
        if (!$blog) return response()->json([
            'status' => 400,
            'message' => "You can't update this blog.",
            'data' => null
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Blog updated successfully',
            'data' => $blog
        ]);
    }

    public function deleteBlog(Request $request ,$id)
    {
        if ($this->blogRepository->deleteBlog($id, $request->user()->id)) {
            return response()->json([
                'status' => 200,
                'message' => 'Blog deleted successfully',
                'data' => null
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => "You can't delete this blog.",
                'data' => null
            ]);
        }
   }
}
