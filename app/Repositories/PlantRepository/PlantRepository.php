<?php

namespace App\Repositories\PlantRepository;

use App\Models\Plant;

class PlantRepository
{

    private $plantModel;

    public function __construct(Plant $model)
    {
        $this->plantModel = $model;
    }

    public function storePlant(array $data)
    {
        return $this->plantModel->create($data);
    }

    public function returnAllPlants()
    {
        return $this->plantModel->latest()->get();
    }

    public function returnPlantById(int $id)
    {
        return $this->plantModel->find($id);
    }

    public function deletePlant(int $id)
    {
        $plant = $this->returnPlantById($id);

        if (!$plant) {
            return false;
        }

        return $plant->delete();
    }

    public function updatePlant(int $id, array $data)
    {
        $plant = $this->returnPlantById($id);
        if (!$plant) {
            return false;
        }

        return $plant->update($data);
    }
}
