<?php

    namespace App\Http\Controllers\Authenticate;

    use App\Http\Exceptions\RequestException;
    use App\Http\Requests\Authenticate\LoginRequest;
    use App\Http\Requests\Authenticate\RegisterRequest;
    use App\Http\Responses\API\ApiErrorResponse;
    use App\Http\Responses\API\ApiSuccessResponse;
    use App\Models\User;
    use App\Repository\User\UserRepository;
    use Exception;
    use Illuminate\Support\Facades\Hash;

    class AuthController
    {
        /*
        *   Register a new User.
        *   Before manual validation is not an administrator and it is not active
        */
        public function register(RegisterRequest $request): ApiErrorResponse|ApiSuccessResponse
        {
            try {
                $user = [
                    'name' => $request->validated('name'),
                    'email' => $request->validated('email'),
                    'password' => $request->validated('password'),
                    'user_type_id' => 2
                ];

                (new UserRepository())->create($user);

                return new ApiSuccessResponse([
                    'user' => $user
                ],
                    "New user successfully created, need activated by admin for full features access", 201);
            } catch (Exception $e) {
                return new ApiErrorResponse($e->getMessage(), $e);
            }
        }

        /*
         * Logs in as administrator and sends a new token to access protected endpoints.
         * The token is valid for 1 hour.
         */
        /**
         * @throws RequestException
         */
        public function login(LoginRequest $request): ApiSuccessResponse|ApiErrorResponse
        {
            $identifiers = [
                'email' => $request->validated('email'),
                'password' => $request->validated('password'),
            ];

            $user = User::where('email', $identifiers['email'])->first();

            if (is_null($user)) {
                return new ApiSuccessResponse([
                    "userMail" => $identifiers['email']
                ], "User not found", 404);
            }

            if (Hash::check($identifiers['password'], $user->password) && ($user->is_active)) {
                $expirationTime = now()->addMinutes(60);
                $token = $user->createToken(time(), ['*'], $expirationTime)->plainTextToken;

                return new ApiSuccessResponse([
                    "token" => $token,
                    'expiration_date' => $expirationTime->format('d-m-Y H:i:s')
                ],
                    "Logged in successfully, use your Bearer token to authenticate on protected endpoints", 200);
            }
            return new ApiErrorResponse('Login failed', throw new RequestException());
        }

        /*
         * Revoke token, protected end points are closed for current user
         */
        public function logout(): ApiSuccessResponse
        {
            auth()->user()->tokens()->delete();

            return new ApiSuccessResponse([], "Logged out, token revoked", 200);
        }
    }
