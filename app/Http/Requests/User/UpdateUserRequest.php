<?php

namespace App\Http\Requests\User;


use App\Enum\UserType;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends BaseUserRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'uuid' => $this->defaultPostInputValidation('uuid'),
            'name' => $this->defaultPostInputValidation($this->post('name')),
            'phone' => $this->defaultPostInputValidation('phone'),
            'birth' => $this->defaultPostInputValidation('birth'),
        ]);

        $this->preparedIndividualProfileData();
        $this->preparedCompanyProfileData();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'uuid' => ['required', 'uuid:7'],
            'name' => ['required', 'string', 'max:255'],
            'userType' => ['required', Rule::enum(UserType::class)],
            'phone' => ['nullable', 'string', 'max:20'],
            'birth' => ['nullable', 'date'],
        ];

        if ($this->post('userType') === UserType::INDIVIDUAL->value) {
            return array_merge($rules, $this->individualProfileRule());
        } elseif ($this->post('userType') === UserType::COMPANY->value) {
            return array_merge($rules, $this->companyProfileRule());
        }

        return $rules;
    }
}
