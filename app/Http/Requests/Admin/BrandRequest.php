<?php

namespace App\Http\Requests\Admin;

use App\Enums\BrandSegment;
use App\Models\Brand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
{
    /**
     * Run the policy check before validation, so unauthorized users get a 403
     * rather than validation feedback about content they cannot touch.
     */
    public function authorize(): bool
    {
        $model = $this->route('brand');

        return $model
            ? $this->user()->can('update', $model)
            : $this->user()->can('create', Brand::class);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $brand = $this->route('brand');

        return [
            'name' => ['required', 'string', 'max:60', Rule::unique('brands', 'name')->ignore($brand)],
            'segment' => ['required', Rule::enum(BrandSegment::class)],
            'tagline' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:1000'],
            'accent_color' => ['required', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active' => ['required', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
        ];
    }
}
