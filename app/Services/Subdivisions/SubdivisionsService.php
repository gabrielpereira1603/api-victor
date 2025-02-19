<?php

namespace App\Services\Subdivisions;

use App\Exceptions\Api\ApiException;
use App\Models\Blocks;
use App\Repositories\Blocks\BlocksRepository;
use App\Repositories\Subdivisions\SubdivisionsRepository;

class SubdivisionsService
{
    private SubdivisionsRepository $subdivisionsRepository;

    public function __construct(SubdivisionsRepository $subdivisionsRepository)
    {
        $this->subdivisionsRepository = $subdivisionsRepository;
    }

    public function createSubdivisions(array $data): Blocks
    {
        try {
            return $this->blocksRepository->createBlocks($data);
        } catch (\Throwable $e) {
            throw new ApiException(
                'Error ao cadastrar o loteamento.',
                500,
                ['internalMessage' => $e->getMessage()]
            );
        }
    }
}
