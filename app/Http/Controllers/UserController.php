<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->userService->getUserWithDetails($id);
            return response()->json(['user' => $user]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve user',
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
