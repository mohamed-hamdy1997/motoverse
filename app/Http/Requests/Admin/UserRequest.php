<?php

namespace App\Http\Requests\Admin;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    /**
     * Run the policy check before validation, so unauthorized users get a 403
     * rather than validation feedback about content they cannot touch.
     */
    public function authorize(): bool
    {
        $model = $this->route('user');

        return $model
            ? $this->user()->can('update', $model)
            : $this->user()->can('create', User::class);
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user)],
            'role' => ['required', Rule::enum(UserRole::class)],
            'password' => [$user ? 'nullable' : 'required', 'string', Password::defaults(), 'confirmed'],
            'brand_ids' => [
                Rule::requiredIf($this->input('role') === UserRole::DataEntry->value),
                'array',
            ],
            'brand_ids.*' => ['integer', 'distinct', Rule::exists('brands', 'id')],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'brand_ids.required' => 'Assign at least one brand to a data-entry user.',
        ];
    }
}
