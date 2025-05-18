<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // GET /api/admin/services
    public function index()
    {
        $services = Service::all();
        return response()->json([
            'message' => 'Service list retrieved successfully',
            'services' => $services
        ]);
    }

    // POST /api/admin/services
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:services,name',
        ]);

        $service = Service::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Service added successfully',
            'service' => $service
        ]);
    }

    // PUT /api/admin/services/{id}
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:services,name,' . $id . ',service_id',
        ]);

        $service = Service::findOrFail($id);
        $service->name = $request->name;
        $service->save();

        return response()->json([
            'message' => 'Service updated successfully',
            'service' => $service
        ]);
    }

    // DELETE /api/admin/services/{id}
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json([
            'message' => 'Service deleted successfully'
        ]);
    }
}
