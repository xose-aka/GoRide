<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDriverRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function show(Request $request): UserResource|JsonResponse
    {
        $user = $request->user();

        if ( $user instanceof User) {
            $user->load('driver');

            return new UserResource($user);
        }

        return response()->json([
            'message' => 'User not found'
        ], 404);
    }

    public function update(UpdateDriverRequest $request): UserResource|JsonResponse
    {
        $user = $request->user();

        if ( $user instanceof User) {
            $user->driver()
                ->updateOrCreate($request->only([
                    'year',
                    'make',
                    'color',
                    'license_plate',
                ]));

            $user->load('driver');

            return new UserResource($user);
        }

        return response()->json([
            'message' => 'User not found'
        ], 404);
    }
}
