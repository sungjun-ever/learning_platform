<?php

namespace App\Exceptions\User;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class DeleteUserException extends Exception
{
    public function report(Request $request): void
    {
        Log::error('사용자 삭제 실패',[
            'message' => $this->getMessage(),
            'data' => $request->all(),
        ]);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'status' => 'fail',
            'message' => 'DESTROY_FAILED',
        ], 500);
    }
}
