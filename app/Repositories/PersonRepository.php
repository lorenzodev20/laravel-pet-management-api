<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\Api\V1\Person\UpdatePersonRequest;
use App\Models\Person;

class PersonRepository extends BaseRepository
{
    public function __construct(Person $model)
    {
        parent::__construct($model, ['pets']);
    }

    public function updateDirtyData(UpdatePersonRequest $request, int $id)
    {
        $model = $this->get($id);
        $model->name = $request->input('name');
        $model->email = $request->input('email');
        $model->birthdate = $request->input('birthdate');

        if ($model->isDirty()) {
            $this->save($model);
        }
    }
}
