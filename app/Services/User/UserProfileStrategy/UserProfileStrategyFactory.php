<?php

namespace App\Services\User\UserProfileStrategy;

use App\Enum\UserType;

readonly class UserProfileStrategyFactory
{

    public function __construct(
        private IndividualProfileStrategy $individualProfileStrategy,
        private CompanyProfileStrategy    $companyProfileStrategy,
    )
    {
    }

    public function make(string $userType): ?IUserProfileStrategy
    {
        return match ($userType) {
            UserType::INDIVIDUAL->value => $this->individualProfileStrategy,
            UserType::COMPANY->value => $this->companyProfileStrategy,
            default => null,
        };
    }
}