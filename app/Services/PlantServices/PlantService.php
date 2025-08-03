<?php

namespace App\Services\PlantServices;

use App\Repositories\PlantRepository\PlantRepository;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PlantService
{
    private $repository;

    public function __construct(PlantRepository $plantRepository)
    {
        $this->repository = $plantRepository;
    }

    public function createNewPlant(array $data)
    {
        return $this->repository->storePlant($data);
    }

    public function getAllPlants()
    {
        return $this->repository->returnAllPlants();
    }

    public function getPlantById(int $id)
    {
        return $this->repository->returnPlantById($id);
    }

    public function deletePlantRequest(int $id)
    {
        $deletePlant = $this->repository->deletePlant($id);

        if (!$deletePlant) {
            throw new HttpException(404, 'Not found!');
        }

        return true;
    }

    public function updatePlantRequest(int $id, array $data)
    {
        $updatePlant = $this->repository->updatePlant($id, $data);
        if (!$updatePlant) {
            throw new HttpException(404, 'Not found!');
        }

        return true;
    }
}
