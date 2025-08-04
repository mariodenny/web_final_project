<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\DeviceServices\DeviceService;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DeviceController extends Controller
{

    private $service;

    public function __construct(DeviceService $deviceService)
    {
        $this->service = $deviceService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plant_id' => 'required|exists:plants,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|max:2048|mimes:png,jpg,jpeg',
            'mac_address' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('devices', 'public');
            $validated['image_url'] = asset('storage/' . $path);
        }

        try {
            $device = $this->service->storeDeviceRequest($validated);
            return ApiResponse::success($device);
        } catch (HttpException $err) {
            return ApiResponse::error($err->getMessage(), $err->getStatusCode());
        }
    }

    public function index()
    {
        try {
            $devices = $this->service->getAllDeviceRequest();
            return ApiResponse::success($devices);
        } catch (HttpException $err) {
            return ApiResponse::error($err->getMessage(), $err->getStatusCode());
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->service->deleteDeviceRequest($id);
            return  ApiResponse::success(true);
        } catch (HttpException $err) {
            return ApiResponse::error($err->getMessage(), $err->getStatusCode());
        }
    }

    public function updateDevice(Request $request, int $id)
    {
        $validated = $request->validate([
            'plant_id' => 'sometimes|exists:plants,id',
            'name' => 'sometimes|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'mac_address' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('devices', 'public');
            $validated['image_url'] = asset('storage/' . $path);
        }

        try {
            $device = $this->service->updateDeviceRequest($id, $validated);
            return ApiResponse::success($device);
        } catch (HttpException $err) {
            return ApiResponse::error($err->getMessage(), $err->getStatusCode());
        }
    }
}
