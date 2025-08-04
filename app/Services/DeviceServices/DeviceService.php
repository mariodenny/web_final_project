<?php

namespace App\Services\DeviceServices;

use App\Repositories\DeviceRepository\DeviceRepository;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DeviceService
{

    private $repository;

    public function __construct(DeviceRepository $deviceRepository)
    {
        $this->repository = $deviceRepository;
    }

    public function storeDeviceRequest(array $data)
    {
        $nowAsiaJakarta = Carbon::now('Asia/Jakarta');

        $deviceData = [
            'plant_id' => $data['plant_id'],
            'name' => $data['name'],
            'description' => $data['description'] || null,
            'image_url' => $data['image_url'] || null,
            'mac_address' => $data['mac_address'] || null,
            'last_active_at' => $data['last_active_at'] || $nowAsiaJakarta,
            'created_at' => $nowAsiaJakarta,
            'updated_at' => $nowAsiaJakarta
        ];

        return $this->repository->createNewDevice($deviceData);
    }

    public function getAllDeviceRequest()
    {
        return $this->repository->getAllDevices();
    }

    public function getDeviceByIdRequest(int $id)
    {
        $device = $this->repository->findDeviceById($id);

        if (!$device) {
            throw new HttpException(404, 'Device not found');
        }

        return $device;
    }

    public function deleteDeviceRequest(int $id)
    {
        $deleteDevice = $this->repository->deleteDeviceById($id);

        if (!$deleteDevice) {
            throw new HttpException(404, 'Device not found');
        }

        return true;
    }

    public function updateDeviceRequest(int $id, array $data)
    {
        $updateDevice = $this->repository->updateDeviceById($id, $data);

        if (!$updateDevice) {
            throw new HttpException(404, 'Device not found');
        }

        return true;
    }
}
