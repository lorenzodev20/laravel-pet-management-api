<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\Api\V1\Pet\UpdatePetRequest;
use App\Models\Pet;

class PetRepository extends BaseRepository
{
    public function __construct(Pet $model)
    {
        parent::__construct($model, ['person']);
    }

    public function updateDirtyData(UpdatePetRequest $request, int $id)
    {
        $model = $this->get($id);
        $model->name = $request->input('name');
        $model->species = $request->input('species');
        $model->breed = $request->input('breed');
        $model->age = $request->input('age');
        $model->person_id = $request->input('person_id');
        if ($model->isDirty()) {
            $this->save($model);
        }
    }
}
