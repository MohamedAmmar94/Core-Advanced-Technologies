<?php
namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ContractNotActiveException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => 'Contract is not active.',
            'error'   => 'NOTACTIVE',
        ], 422);
    }
}
