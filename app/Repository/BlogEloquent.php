<?php

namespace App\Repository;

use App\Models\Blog;
use App\Models\BlogCategory;

class BlogEloquent extends BaseEloquent
{
    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }

    public function getAllBlogs()
    {
        return Blog::with(['author', 'categories'])->get();
    }

    public function getBlogById($id)
    {
        return Blog::find($id);
    }

    public function createBlog($data)
    {
        $blog = new Blog;
        $blog->author_id = $data['user_id'];
        $blog->title = $data['title'];
        $blog->content = $data['content'];
        $blog->save();
        if (isset($data['category_ids'])) {
            foreach ($data['category_ids'] as $categoryId) {
                $category = BlogCategory::find($categoryId);
                if ($category) {
                    $blog->categories()->attach($category);
                }
            }
        }
        $blog->save();

        return $blog;
    }

    public function updateBlog($id, $data)
    {
        $blog = Blog::find($id);
        if (isset($data['userId'])) {
            if ($data['userId'] != $blog->author_id) return false;
        }

        if (isset($data['title'])) {
            $blog->title = $data['title'];
        }
        if (isset($data['content'])) {
            $blog->content = $data['content'];
        }
        $blog->save();

        return $blog;
    }

    public function deleteBlog($id, $userId)
    {
        if (!$userId) $blog = Blog::find($id); 
            else $blog = Blog::where('id', $id)->where('author_id', $userId)->first();
        if ($blog) {
            $blog->delete();
            return true;
        }
        return false;
    }
}
