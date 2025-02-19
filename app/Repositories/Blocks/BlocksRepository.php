<?php

namespace App\Repositories\Blocks;


use App\Models\Blocks;

class BlocksRepository
{
    public function createBlocks(array $data): Blocks
    {
        //$appointment->load(['client', 'provider', 'service', 'review']);

        return Blocks::create($data);
    }
}
