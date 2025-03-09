<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginSubmitRequest;
use App\Models\User;
use App\Notifications\LoginVerification;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function submit(LoginSubmitRequest $request): JsonResponse
    {
        $phone = $request->get('phone');

        /** @var User $user */
        $user = User::query()->firstOrCreate([
            'phone' => $phone
        ]);

        if (empty($user)) {
            return response()->json(['message' => "Could not process user with phone number:${$phone}"], 404);
        }

        $user->notify(new LoginVerification());

        return response()->json(['message' => 'Text message notification sent']);
    }
}
