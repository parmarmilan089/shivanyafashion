<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'category_type' => ['required', 'in:0,1,2'],
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attr, $value, $fail) {
                    if ($this->category_type == 1 || $this->category_type == 2) {
                        if (!$value) {
                            $fail('Parent category is required for subcategories.');
                            return;
                        }

                        $parent = \App\Models\Category::find($value);
                        if (!$parent || $parent->category_type != $this->category_type - 1) {
                            $fail('Selected parent category does not match the required hierarchy.');
                        }
                    }
                },
            ],
            'is_active' => ['required', 'in:0,1'],
        ];

        return $rules;
    }
}
