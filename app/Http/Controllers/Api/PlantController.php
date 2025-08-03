<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PlantServices\PlantService;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PlantController extends Controller
{
    private $plantService;

    public function __construct(PlantService $plantService)
    {
        $this->plantService = $plantService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('plants', 'public');
            $validated['image_url'] = asset('storage/' . $path);
        }
        $plant = $this->plantService->createNewPlant($validated);

        if (!$plant) {
            return ApiResponse::error($plant, 400);
        }

        return ApiResponse::success($plant, 'success', 200);
    }

    public function index()
    {
        $plants = $this->plantService->getAllPlants();

        if (!$plants) {
            return ApiResponse::error($plants, 404);
        }

        return ApiResponse::success($plants, 'success', 200);
    }

    public function show(int $id)
    {
        $plant = $this->plantService->getPlantById($id);

        if (!$plant) {
            return ApiResponse::error($plant, 404);
        }

        return ApiResponse::success($plant, 'success', 200);
    }

    public function destroy(int $id)
    {
        try {
            $this->plantService->deletePlantRequest($id);
            return ApiResponse::success('Success', 'Plant Deleted', 200);
        } catch (HttpException $err) {
            return ApiResponse::error($err->getMessage(), $err->getStatusCode());
        }
    }

    public function updatePlants(int $id, Request $request)
    {
        $updateRequest = $request->validate([
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('plants', 'public');
            $updateRequest['image_url'] = asset('storage/' . $path);
        }

        try {
            $plant = $this->plantService->updatePlantRequest($id, $updateRequest);
            return ApiResponse::success($plant);
        } catch (HttpException $err) {
            return ApiResponse::error($err->getMessage(), $err->getStatusCode());
        }
    }
}
