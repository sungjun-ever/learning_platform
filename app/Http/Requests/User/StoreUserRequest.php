<?php

namespace App\Http\Requests\User;

use App\Enum\UserRoleType;
use App\Enum\UserType;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends BaseUserRequest
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
        // userType 구분 없는 기본 정보
        $this->merge([
            'userType' => $this->defaultPostInputValidation('userType'),
            'email' => $this->defaultPostInputValidation('email'),
            'password' => $this->defaultPostInputValidation('password'),
            'name' => $this->defaultPostInputValidation('name'),
            'phone' => $this->defaultPostInputValidation('phone'),
            'birth' => $this->defaultPostInputValidation('birth'),
            'role' => $this->defaultPostInputValidation('role'),
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
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'name' => ['required', 'string', 'max:255'],
            'userType' => ['required', Rule::enum(UserType::class)],
            'phone' => ['nullable', 'string', 'max:20'],
            'birth' => ['nullable', 'date'],
            'role' => ['required', Rule::enum(UserRoleType::class)]
        ];

        if ($this->post('userType') === UserType::INDIVIDUAL->value) {
            return array_merge($rules, $this->individualProfileRule());
        } elseif ($this->post('userType') === UserType::COMPANY->value) {
            return array_merge($rules, $this->companyProfileRule());
        }

        return $rules;
    }
}
