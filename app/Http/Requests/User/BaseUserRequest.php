<?php

namespace App\Http\Requests\User;

use App\Enum\UserType;
use App\Http\Requests\BaseFormRequest;

abstract class BaseUserRequest extends BaseFormRequest
{
    /**
     * userType: individual 추가 정보
     * @return void
     */
    public function preparedIndividualProfileData(): void
    {
        if ($this->post('userType') !== UserType::INDIVIDUAL->value) {
            return;
        }

        $this->merge([
            'job' => $this->defaultPostInputValidation('job'),
            'career' => $this->defaultPostInputValidation('career'),
        ]);

    }

    /**
     * userType: company 추가 정보
     * @return void
     */
    public function preparedCompanyProfileData(): void
    {
        if ($this->post('userType') !== UserType::COMPANY->value) {
            return;
        }

        $this->merge([
            'companyId' => $this->defaultPostInputValidation('companyId'),
            'position' => $this->defaultPostInputValidation('position'),
            'department' => $this->defaultPostInputValidation('department'),
            'employeeNumber' => $this->defaultPostInputValidation('employeeNumber'),
            'joinedAt' => $this->defaultPostInputValidation('joinedAt'),
            'leftAt' => $this->defaultPostInputValidation('leftAt')
        ]);
    }

    public function individualProfileRule(): array
    {
        return [
            'job' => ['nullable', 'string', 'max:255'],
            'career' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function companyProfileRule(): array
    {
        return [
            'companyId' => ['nullable', 'integer'],
            'position' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'employeeNumber' => ['nullable', 'string', 'max:50'],
            'joinedAt' => ['nullable', 'date'],
            'leftAt' => ['nullable', 'date'],
        ];
    }
}