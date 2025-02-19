<?php

namespace App\Http\Requests\Api\Blocks;

use Illuminate\Foundation\Http\FormRequest;

class CreateBlocksRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

        ];
    }
}
