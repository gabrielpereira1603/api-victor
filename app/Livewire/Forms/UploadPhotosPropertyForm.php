<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class UploadPhotosPropertyForm extends Form
{
    use WithFileUploads;

    #[Validate(['photos.*' => 'image|max:2048'])]
    public $photos = [];

    public $image_url;
    public $file_name;
    public $file_type;

    public function store()
    {
        if ($this->photos) {
            foreach ($this->photos as $photo) {
                $photo->store('photos');
            }
        }
    }
}
