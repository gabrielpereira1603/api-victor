<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    public function run()
    {
        $states = [
            ['name' => 'São Paulo', 'slug' => 'sao-paulo'],
            ['name' => 'Rio de Janeiro', 'slug' => 'rio-de-janeiro'],
        ];

        foreach ($states as $state) {
            State::create($state);
        }
    }
}
