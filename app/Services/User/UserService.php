<?php

namespace App\Services\User;

use App\Dto\User\CreateUserData;
use App\Dto\User\UpdateUserData;
use App\Enum\UserType;
use App\Exceptions\User\CreateUserException;
use App\Exceptions\User\UpdateUserException;
use App\Models\User;
use App\Repositories\User\IUserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

readonly class UserService
{
    public function __construct(
        private IUserRepository $userRepository,
    )
    {
    }

    private function getProfileStrategy(string $userType): IUserProfileStrategy|null
    {
        return match ($userType) {
            UserType::INDIVIDUAL->value => new IndividualProfileStrategy(),
            UserType::COMPANY->value => new CompanyProfileStrategy(),
            default => null,
        };
    }

    /**
     * uuid로 사용자 가져오기
     * @param string $uuid
     * @return User
     * @throws ModelNotFoundException
     */
    public function getUserUseUuid(string $uuid): User
    {
        $user = $this->userRepository->findByUuid($uuid);

        if (!$user) {
            throw new ModelNotFoundException("사용자를 찾을 수 없습니다.");
        }

        $profile = match ($user->user_type) {
            UserType::INDIVIDUAL->value => 'individualProfile',
            UserType::COMPANY->value => 'companyProfile',
            default => null,
        };

        if ($profile) {
            $user->load($profile);
        }

        return $user;
    }

    /**
     * 사용자 생성
     * @param array $data
     * @return string
     * @throws \Throwable
     */
    public function createUser(array $data): string
    {
        $userUuid = null;

        DB::transaction(function () use ($data, &$userUuid) {
            $createUserData = new CreateUserData(
                uuid: Uuid::uuid7()->toString(),
                email: $data['email'],
                password: $data['password'],
                name: $data['name'],
                userType: $data['userType'],
                phone: $data['phone'] ?? null,
                birth: $data['birth'] ?? null,
            );

            $user = $this->userRepository->create($createUserData->toArray());

            if (!$user) {
                throw new CreateUserException('사용자 생성에 실패했습니다.');
            }

            $profileStrategy = $this->getProfileStrategy($user->user_type);

            $profileStrategy?->createProfile($user, $data);

            $userUuid = $user->uuid;
        });

        return $userUuid;
    }

    /**
     * 사용자 정보 수정
     * @param string $uuid
     * @param array $data
     * @return string
     * @throws \Throwable
     */
    public function updateUser(string $uuid, array $data): string
    {
        DB::transaction(function () use ($uuid, $data) {
            $updateUserData = new UpdateUserData(
                name: $data['name'],
                phone: $data['phone'] ?? null,
                birth: $data['birth'] ?? null,
            );

            $user = $this->userRepository->findByUuid($uuid);

            if (!$user) {
                throw new ModelNotFoundException("사용자 가져오기 실패 uuid: $uuid");
            }

            $updateUser = $user->update($updateUserData->toArray());

            if (!$updateUser) {
                throw new UpdateUserException("사용자 수정 실패 uuid: $uuid");
            }

            $profile = $this->getProfileStrategy($data['userType']);
            $profile?->updateProfile($user, $data);
        });

        return $uuid;
    }

}