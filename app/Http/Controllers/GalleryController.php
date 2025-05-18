<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    // GET /api/galleries
    public function index()
    {
        return response()->json([
            'message' => 'Gallery list retrieved successfully',
            'galleries' => Gallery::all()
        ]);
    }

    // POST /api/galleries
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'image' => 'required|string' // image path or URL
        ]);

        $gallery = Gallery::create($request->only(['name', 'image']));

        return response()->json([
            'message' => 'Gallery item added successfully',
            'gallery' => $gallery
        ]);
    }

    // PUT /api/galleries/{id}
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'image' => 'required|string'
        ]);

        $gallery->update($request->only(['name', 'image']));

        return response()->json([
            'message' => 'Gallery item updated successfully',
            'gallery' => $gallery
        ]);
    }

    // DELETE /api/galleries/{id}
    public function destroy($id)
    {
        Gallery::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Gallery item deleted successfully'
        ]);
    }
}
