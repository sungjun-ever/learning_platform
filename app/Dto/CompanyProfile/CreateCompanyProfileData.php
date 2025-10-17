<?php

namespace App\Dto\CompanyProfile;

readonly class CreateCompanyProfileData
{

    public function __construct(
        public int     $userId,
        public int     $companyId,
        public ?string $position = null,
        public ?string $department = null,
        public ?string $employeeNumber = null,
        public ?string $joinedAt = null,
        public ?string $leftAt = null,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'company_id' => $this->companyId,
            'position' => $this->position,
            'department' => $this->department,
            'employee_number' => $this->employeeNumber,
            'joined_at' => $this->joinedAt,
            'left_at' => $this->leftAt,
        ];
    }
}