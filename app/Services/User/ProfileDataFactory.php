<?php

namespace App\Services\User;

use App\Dto\UserProfile\CreateCompanyProfileData;
use App\Dto\UserProfile\CreateIndividualProfileData;
use App\Dto\UserProfile\IProfileData;
use App\Dto\UserProfile\UpdateCompanyProfileData;
use App\Dto\UserProfile\UpdateIndividualProfileData;
use App\Enum\UserType;

readonly class ProfileDataFactory
{
    public function makeCreateData(string $userType, int $userId, array $data): ?IProfileData
    {
        return match ($userType) {
            UserType::INDIVIDUAL->value => new CreateIndividualProfileData(
                userId: $userId,
                job: $data['job'] ?? null,
                career: $data['career'] ?? null
            ),
            UserType::COMPANY->value => new CreateCompanyProfileData(
                userId: $userId,
                companyId: $data['companyId'],
                position: $data['position'] ?? null,
                department: $data['department'] ?? null,
                employeeNumber: $data['employeeNumber'] ?? null,
                joinedAt: $data['joinedAt'] ?? null,
                leftAt: $data['leftAt'] ?? null,
            ),
            default => null,
        };
    }

    public function makeUpdateData(string $userType, array $data): ?IProfileData
    {
        return match ($userType) {
            UserType::INDIVIDUAL->value => new UpdateIndividualProfileData(
                job: $data['job'] ?? null,
                career: $data['career'] ?? null,
            ),
            UserType::COMPANY->value => new UpdateCompanyProfileData(
                companyId: $data['companyId'],
                position: $data['position'] ?? null,
                department: $data['department'] ?? null,
                employeeNumber: $data['employeeNumber'] ?? null,
                joinedAt: $data['joinedAt'] ?? null,
                leftAt: $data['leftAt'] ?? null,
            ),
            default => null
        };
    }
}