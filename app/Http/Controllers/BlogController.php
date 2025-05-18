<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // GET /api/blogs
    public function index()
    {
        $blogs = Blog::with('gallery')->get();

        return response()->json([
            'message' => 'Blog list retrieved successfully',
            'blogs' => $blogs
        ]);
    }

    // POST /api/blogs
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'gallery_id' => 'required|exists:galleries,gallery_id',
        ]);

        $blog = Blog::create($request->only(['title', 'description', 'gallery_id']));

        return response()->json([
            'message' => 'Blog created successfully',
            'blog' => $blog
        ]);
    }

    // PUT /api/blogs/{blog_id}
    public function update(Request $request, $blog_id)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'gallery_id' => 'required|exists:galleries,gallery_id',
        ]);

        $blog = Blog::findOrFail($blog_id);
        $blog->update($request->only(['title', 'description', 'gallery_id']));

        return response()->json([
            'message' => 'Blog updated successfully',
            'blog' => $blog
        ]);
    }

    // DELETE /api/blogs/{blog_id}
    public function destroy($blog_id)
    {
        $blog = Blog::findOrFail($blog_id);
        $blog->delete();

        return response()->json([
            'message' => 'Blog deleted successfully'
        ]);
    }
}
