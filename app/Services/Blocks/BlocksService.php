<?php

namespace App\Services\Blocks;


use App\Exceptions\Api\ApiException;
use App\Models\Blocks;
use App\Repositories\Blocks\BlocksRepository;

class BlocksService
{
    private BlocksRepository $blocksRepository;

    public function __construct(BlocksRepository $blocksRepository)
    {
        $this->blocksRepository = $blocksRepository;
    }

    public function createBlock(array $data): Blocks
    {
        try {
            return $this->blocksRepository->createBlocks($data);
        } catch (\Throwable $e) {
            throw new ApiException(
                'Error ao cadastrar o quarteirão.',
                500,
                ['internalMessage' => $e->getMessage()]
            );
        }
    }
}
