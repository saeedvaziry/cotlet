<?php

namespace SaeedVaziry\Cotlet\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;
use SaeedVaziry\Cotlet\Traits\Tokens;

class LoginController extends Controller
{
    use Tokens;

    /**
     * @param Request $request
     *
     * @return JsonResource
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validateForm($request);

        $user = auth('cotlet')->attempt($request->all([config('cotlet.username_field'), config('cotlet.password_field')]));

        if (!$user) {
            throw ValidationException::withMessages([config('cotlet.username_field') => 'Invalid credentials!']);
        }

        return response()->json([
            'access_token' => $this->generateToken($user)
        ]);
    }

    /**
     * @param Request $request
     *
     * @return void
     */
    protected function validateForm(Request $request): void
    {
        $request->validate([
            config('cotlet.username_field') => 'required',
            config('cotlet.username_field') => 'required'
        ]);
    }
}
