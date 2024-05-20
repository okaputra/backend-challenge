<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Str;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'password' => bcrypt($request->password),
            'remember_token' => Str::random(60),
        ]);

        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Registration successfully. Please verify your email.'], 201);
    }

    public function verifyEmail(Request $request)
    {
        $user = User::where('remember_token', $request->code)->firstOrFail();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.'], 200);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json(['message' => 'Email successfully verified.'], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (!$user->hasVerifiedEmail()) {
                return response()->json(['error' => 'Email not verified.'], 403);
            }

            // Revoke previous tokens if needed
            $user->tokens()->delete();

            // Create a new token
            $tokenResult = $user->createToken('BackendChallenge');
            $token = $tokenResult->plainTextToken;

            return response()->json([
                'message' => 'Login success',
                'token' => $token,
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function dashboard(Request $request)
    {
        // Check if the request contains an access token
        if ($request->bearerToken()) {
            // Retrieve the authenticated user based on the provided token
            $me = Auth::user();
            $users = User::paginate(10);

            return response()->json([
                'total_users' => User::count(),
                'my_account' => new UserResource($me),
                'users' => UserResource::collection($users),
                'pagination' => [
                    'total' => $users->total(),
                    'per_page' => $users->perPage(),
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'next_page_url' => $users->nextPageUrl(),
                    'prev_page_url' => $users->previousPageUrl(),
                    'from' => $users->firstItem(),
                    'to' => $users->lastItem(),
                ],
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
