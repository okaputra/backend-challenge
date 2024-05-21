<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    // Method to redirect user
    public function redirect($social_media)
    {
        $validated = $this->validateSosmed($social_media);
        if (!is_null($validated)) {
            return $validated;
        }
        return Socialite::driver($social_media)->stateless()->redirect();
    }
    // Handle callback social media authentication
    public function callback($social_media)
    {
        $validated = $this->validateSosmed($social_media);
        if (!is_null($validated)) {
            return $validated;
        }
        try {
            $user = Socialite::driver($social_media)->stateless()->user();
        } catch (ClientException $exception) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }

        $userCreated = User::firstOrCreate(
            [
                'email' => $user->getEmail()
            ],
            [
                'email_verified_at' => now(),
                'nama' => $user->getName(),
                'status' => true,
            ]
        );
        $userCreated->social_media()->updateOrCreate(
            [
                'social_media' => $social_media,
                'social_media_id' => $user->getId(),
            ],
            [
                'avatar' => $user->getAvatar()
            ]
        );
        $token = $userCreated->createToken('token-name')->plainTextToken;

        // return response()->json($userCreated, 200, ['Access-Token' => $token]);
        return response()->json([
            'message' => 'Login success',
            'user' => $userCreated,
            'token' => $token,
        ], 200);
    }

    protected function validateSosmed($social_media)
    {
        if (!in_array($social_media, ['facebook', 'google'])) {
            return response()->json(['error' => 'Please login using facebook or google'], 422);
        }
    }
}
