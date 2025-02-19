<?php

namespace App\Repositories\Subdivisions;

use App\Models\Subdivision;

class SubdivisionsRepository
{
    public function createSubdvisions(array $data): Subdivision
    {
        //$appointment->load(['client', 'provider', 'service', 'review']);
        return Subdivision::create($data);
    }
}
