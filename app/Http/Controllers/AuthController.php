<?php

    namespace App\Http\Controllers;

    use AllowDynamicProperties;
    use App\Http\Requests\LoginRequest;
    use App\Http\Requests\RegisterRequest;
    use App\Models\User;
    use Exception;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Hash;

    #[AllowDynamicProperties] class AuthController extends ProfileController
    {
        public function register(RegisterRequest $request): JsonResponse
        {
            try {
                $fields = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $request->password
                ];

                $user = User::create([
                    'name' => $fields['name'],
                    'email' => $fields['email'],
                    'password' => bcrypt($fields['password'])

                ]);

            } catch (Exception $e) {
                return $this->apiResponse->error($e->getMessage(), 500, $e->getCode());
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->apiResponse->success("New user successfully created, need activated by admin for full features access", 201, [
                'user' => $user,
                'token' => $token
            ]);
        }

        public function login(LoginRequest $request): JsonResponse
        {
            $identifiers = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            $user = User::where('email', $identifiers['email'])->first();

            if (is_null($user)) {
                return $this->apiResponse->error("User not found", 404, ["userMail" => $identifiers['email']]);
            }

            if (Hash::check($identifiers['password'], $user->password) && ($user->is_active)) {
                $expirationTime = now()->addMinutes(60);
                $token = $user->createToken(time(), ['*'], $expirationTime)->plainTextToken;

                return $this->apiResponse->success("Logged in successfully, use your Bearer token to authenticate on protected endpoints", 200, [
                    "token" => $token,
                    'expiration_date' => $expirationTime->format('d-m-Y H:i:s')
                ]);
            }
            return $this->apiResponse->error('Login failed', 422);
        }

        public function logout(): JsonResponse
        {
            auth()->user()->tokens()->delete();

            return $this->apiResponse->success("Logged out, token revoked", 200, []);
        }
    }
