<?php
namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class InsufficientBalanceException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => 'Insufficient balance to complete this operation.',
            'error'   => 'INSUFFICIENT_BALANCE',
        ], 422);
    }
}
