<?php

namespace SaeedVaziry\Cotlet\Exceptions;

use Exception;

class InvalidToken extends Exception
{
    public function render()
    {
        return response()->json([
            'message' => __('Invalid token!')
        ], 401);
    }
}
