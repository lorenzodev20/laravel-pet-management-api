<?php

declare(strict_types=1);

namespace App\Services\Pet;

use Exception;
use App\Models\Pet;
use App\Traits\LogErrors;
use App\Repositories\PetRepository;
use App\Services\TheCatApi\CatService;

class CompletePetService
{
    use LogErrors;

    public function __construct(
        private PetRepository $petRepository,
        private CatService $catService
    ) {}

    public function completeBreedInformation(Pet $pet)
    {
        try {
            # Propiedades del api externa
            $breedProps = $this->catService->getBreedProperties($pet?->breed);

            if (empty($breedProps)) {
                throw new Exception("Información de la raza no encontrada, consulte el listado de razas disponibles", 404);
            }
            $breedProps = $breedProps[0];
            $referenceImage = $this->catService->getReferenceImage($breedProps?->reference_image_id);

            #Adicionar al modelo
            $pet->life_span = $breedProps?->life_span;
            $pet->adaptability = $breedProps?->adaptability;
            $pet->reference_image_id = $breedProps?->reference_image_id;
            $pet->image_url = $referenceImage?->url;

            $this->petRepository->save($pet);
        } catch (\Throwable $th) {
            $this->printLog($th);
            throw $th;
        }
    }
}
