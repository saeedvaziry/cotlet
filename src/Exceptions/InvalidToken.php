<?php

namespace SaeedVaziry\Cotlet\Exceptions;

use Exception;

class InvalidToken extends Exception
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json([
            'message' => __('Invalid token!')
        ], 401);
    }
}
