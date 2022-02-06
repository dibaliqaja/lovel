<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:1|unique:categories,name,'.$this->category->id,
            'slug' => 'required|string|unique:categories,slug,'.$this->category->id
        ];
    }

    protected function getValidatorInstance()
    {
        $data = $this->all();
        $data['slug'] = Str::slug($data['name']);
        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
