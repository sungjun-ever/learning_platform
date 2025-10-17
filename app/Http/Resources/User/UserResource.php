<?php

namespace App\Http\Resources\User;

use App\Enum\UserType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userData = [
            'uuid' => $this->uuid,
            'userType' => $this->user_type,
            'email' => $this->email,
            'name' => $this->name,
            'birth' => $this->birth,
            'phone' => $this->phone,
        ];

        if ($this->user_type === UserType::INDIVIDUAL->value) {
            $userData['profile'] = [
              'job' => $this->individualProfile->job,
              'career' => $this->individualProfile->career,
            ];
        }

        if ($this->user_type === UserType::COMPANY->value) {

            $userData['company'] = [
                'code' => $this->company->code,
                'name' => $this->company->name,
            ];

            $userData['profile'] = [
                'companyId' => $this->companyProfile->company_id,
                'position' => $this->companyProfile->position,
                'department' => $this->companyProfile->department,
                'employeeNumber' => $this->companyProfile->employee_number,
                'joinedAt' => $this->companyProfile->joined_at,
                'leftAt' => $this->companyProfile->left_at,
            ];
        }

        return $userData;
    }
}
