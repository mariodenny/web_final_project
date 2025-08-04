<?php

namespace App\Repositories\DeviceRepository;

use App\Models\Device;

class DeviceRepository
{
    private $model;

    public function __construct(Device $deviceModel)
    {
        $this->model = $deviceModel;
    }

    public function createNewDevice(array $data)
    {
        return $this->model->create($data);
    }

    public function getAllDevices()
    {
        return $this->model->with('sensors')->get();
    }
    public function findDeviceById(int $id)
    {
        return $this->model->with('sensors')->findOrFail($id);
    }

    public function deleteDeviceById(int $id)
    {
        $device = $this->findDeviceById($id);

        if (!$device) {
            return false;
        }
        return $device->delete();
    }

    public function findDeviceWithSensors(int $id): Device
    {
        return $this->model->withCount('sensors')->findOrFail($id);
    }

    public function updateDeviceById(int $id, array $data): bool
    {
        $device = $this->findDeviceById($id);

        if (!$device) {
            return false;
        }

        return $device->update($data);
    }

    public function updateLastActiveAt(int $id, $time)
    {
        $device = $this->findDeviceById($id);

        if (!$device) {
            return false;
        }

        return $device->update([
            'last_active_at' => $time
        ]);
    }
}
