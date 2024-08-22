<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\TransactionService;
use App\Http\Requests\TransactionRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    /**
     * @var TransactionService
     */
    private TransactionService $transactionService;

    /**
     * @param TransactionService $transactionService
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * @param TransactionRequest $request
     * @param User $user
     * @return JsonResponse
     * @throws Exception
     */
    public function store(TransactionRequest $request, User $user): JsonResponse
    {
        try {
            $transaction = $this->transactionService->create($user, $request->validated());
            return response()->json(['transaction' => $transaction], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Payment failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
