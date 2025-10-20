<?php

namespace App\Dto\UserProfile;

readonly class UpdateCompanyProfileData implements IProfileData
{

    public function __construct(
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
            'company_id' => $this->companyId,
            'position' => $this->position,
            'department' => $this->department,
            'employee_number' => $this->employeeNumber,
            'joined_at' => $this->joinedAt,
            'left_at' => $this->leftAt,
        ];
    }
}