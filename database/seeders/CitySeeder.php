<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run()
    {
        $cities = [
            ['name' => 'São Paulo', 'slug' => 'sao-paulo', 'state_id' => 1],
            ['name' => 'Rio de Janeiro', 'slug' => 'rio-de-janeiro', 'state_id' => 2],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
