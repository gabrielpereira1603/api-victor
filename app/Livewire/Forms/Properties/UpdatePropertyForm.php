<?php

namespace App\Livewire\Forms\Properties;

use App\Models\City;
use App\Models\Neighborhood;
use App\Models\Property;
use App\Models\State;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class UpdatePropertyForm extends Form
{
    use WithFileUploads;

    #[Validate('nullable|image|max:2048')]
    public $photo;

    #[Validate('required|string')]
    public $value;

    #[Validate('required|string')]
    public $built_area;

    #[Validate('required|string')]
    public $land_area;

    #[Validate('nullable|integer|min:0')]
    public $bedrooms = 0;

    #[Validate('nullable|integer|min:0')]
    public $bathrooms = 0;

    #[Validate('nullable|integer|min:0')]
    public $suites = 0;

    #[Validate('nullable|integer|min:0')]
    public $living_rooms = 0;

    #[Validate('nullable|integer|min:0')]
    public $kitchens = 0;

    #[Validate('nullable|integer|min:0')]
    public $parking_spaces = 0;

    #[Validate('nullable|integer|min:0')]
    public $pools = 0;
    #[Validate('nullable|integer|min:0')]
    public $ramps = 0;

    #[Validate('nullable|integer|min:0')]
    public $machine_rooms = 0;

    #[Validate('nullable|integer|min:0')]
    public $writtens = 0;

    #[Validate('required|string|max:122')]
    public $neighborhood;

    #[Validate('required|string|max:122')]
    public $city;

    #[Validate('required|string|max:122')]
    public $state;

    #[Validate('required|string|max:1000')]
    public $description;

    #[Validate('nullable|string')]
    public $maps;

    #[Validate('nullable|string')]
    public $photo_url;

    #[Validate('nullable|string')]
    public $file_name;

    #[Validate('nullable|string')]
    public $file_type;

    #[Validate('required|exists:type_properties,id')]
    public $type_property;

    public $errorMessage = '';
    public $validationErrors = [];
    public $new_photo;

    public Property $property;

    public function update()
    {
        DB::beginTransaction();

        try {
            $this->validate();

            if ($this->photo) {
                $oldPhotoPath = str_replace(asset('storage/'), '', $this->property->photo_url);
                if (Storage::disk('public')->exists($oldPhotoPath)) {
                    Storage::disk('public')->delete($oldPhotoPath);
                }

                $this->photo_url = asset('storage/' . $this->photo->store('properties_images', 'public'));
                $this->file_name = $this->photo->getClientOriginalName();
                $this->file_type = $this->photo->getClientMimeType();
            }

            $this->state = State::firstOrCreate(
                ['slug' => Str::slug($this->state)],
                ['name' => $this->state]
            );

            $this->city = City::firstOrCreate(
                [
                    'slug' => Str::slug($this->city),
                    'state_id' => $this->state->id,
                ],
                [
                    'name' => $this->city,
                ]
            );

            $this->neighborhood = Neighborhood::firstOrCreate(
                [
                    'slug' => Str::slug($this->neighborhood),
                ],
                [
                    'name' => $this->neighborhood,
                    'city_id' => $this->city->id,
                ]
            );
            $this->value = trim($this->value);
            $this->value = str_replace(["R$", ".", ","], ["", "", "."], $this->value);
            $this->property->update([
                'value' => $this->value,
                'built_area' => $this->built_area,
                'land_area' => $this->land_area,
                'bedrooms' => $this->bedrooms,
                'bathrooms' => $this->bathrooms,
                'suites' => $this->suites,
                'living_rooms' => $this->living_rooms,
                'kitchens' => $this->kitchens,
                'parking_spaces' => $this->parking_spaces,
                'pools' => $this->pools,
                'ramps' => $this->ramps,
                'machine_rooms' => $this->machine_rooms,
                'writtens' => $this->writtens,
                'description' => $this->description,
                'photo_url' => $this->photo_url ?? $this->property->photo_url,
                'file_name' => $this->file_name ?? $this->property->file_name,
                'file_type' => $this->file_type ?? $this->property->file_type,
                'neighborhood_id' => $this->neighborhood->id,
                'city_id' => $this->city->id,
                'state_id' => $this->state->id,
                'maps' => $this->maps,
                'type_property_id' => $this->type_property,
            ]);
            Log::info('Depois da atualização', [
                'type_property_id' => $this->type_property,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
