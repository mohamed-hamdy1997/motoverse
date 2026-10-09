<?php

namespace App\Http\Requests\Admin;

use App\Models\Promotion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PromotionRequest extends FormRequest
{
    /**
     * Run the policy check before validation, so unauthorized users get a 403
     * rather than validation feedback about content they cannot touch.
     */
    public function authorize(): bool
    {
        $model = $this->route('promotion');

        return $model
            ? $this->user()->can('update', $model)
            : $this->user()->can('create', Promotion::class);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'brand_id' => ['required', 'integer', Rule::in($this->user()->managedBrandIds())],
            'title' => ['required', 'string', 'max:100'],
            'highlight' => ['required', 'string', 'max:40'],
            'description' => ['required', 'string', 'max:500'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after_or_equal:starts_at'],
            'is_active' => ['required', 'boolean'],
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
