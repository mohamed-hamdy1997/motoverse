<?php

namespace App\Http\Requests\Admin;

use App\Enums\MotorcycleCategory;
use App\Models\Motorcycle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MotorcycleRequest extends FormRequest
{
    /**
     * Run the policy check before validation, so unauthorized users get a 403
     * rather than validation feedback about content they cannot touch.
     */
    public function authorize(): bool
    {
        $model = $this->route('motorcycle');

        return $model
            ? $this->user()->can('update', $model)
            : $this->user()->can('create', Motorcycle::class);
    }

    /**
     * The brand must be one the current user manages, so data-entry users
     * cannot create or move a model into a brand they are not assigned to.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'brand_id' => ['required', 'integer', Rule::in($this->user()->managedBrandIds())],
            'name' => ['required', 'string', 'max:80'],
            'category' => ['required', Rule::enum(MotorcycleCategory::class)],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999'],
            'engine_cc' => ['nullable', 'integer', 'min:50', 'max:3000'],
            'power_hp' => ['required', 'integer', 'min:1', 'max:400'],
            'weight_kg' => ['required', 'integer', 'min:50', 'max:600'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_featured' => ['required', 'boolean'],
            'is_published' => ['required', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'brand_id.in' => 'You are not allowed to manage content for this brand.',
        ];
    }
}
