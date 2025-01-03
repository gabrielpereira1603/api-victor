<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Route;

class Breadcrumb extends Component
{
    public array $breadcrumbs = [];

    public function mount()
    {
        $this->generateBreadcrumbs();
    }

    private function generateBreadcrumbs()
    {
        $segments = request()->segments();
        $currentRouteName = Route::currentRouteName();

        $this->breadcrumbs = collect($segments)->map(function ($segment, $index) use ($segments) {
            $url = '/' . implode('/', array_slice($segments, 0, $index + 1));
            $routeName = Route::getRoutes()->match(request()->create($url))->getName();
            return [
                'label' => $this->resolveLabel($routeName, $segment),
                'url' => $url,
            ];
        })->toArray();
    }

    private function resolveLabel(?string $routeName, string $segment): string
    {
        // Tenta usar o nome da rota como label, caso contrário, usa o segmento.
        return $routeName
            ? ucfirst(str_replace('.', ' ', $routeName))
            : ucfirst(str_replace('-', ' ', $segment));
    }

    public function render()
    {
        return view('livewire.breadcrumb');
    }
}
