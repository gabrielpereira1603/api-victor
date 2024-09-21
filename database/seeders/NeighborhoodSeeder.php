<?php

namespace Database\Seeders;

use App\Models\Neighborhood;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NeighborhoodSeeder extends Seeder
{
    public function run()
    {
        $neighborhoods = [
            ['name' => 'Bela Vista', 'slug' => 'bela-vista', 'city_id' => 1],
            ['name' => 'Copacabana', 'slug' => 'copacabana', 'city_id' => 2],
        ];

        foreach ($neighborhoods as $neighborhood) {
            Neighborhood::create($neighborhood);
        }
    }
}
