<?php

    namespace App\Http\Controllers\Authenticate;

    use App\DataTransferObjects\UserDTO;
    use App\Enum\UserTypeEnum;
    use App\Http\Exceptions\RequestException;
    use App\Http\Requests\Authenticate\LoginRequest;
    use App\Http\Requests\Authenticate\RegisterRequest;
    use App\Http\Responses\API\ApiErrorResponse;
    use App\Http\Responses\API\ApiSuccessResponse;
    use App\Models\User;
    use App\Repository\User\UserRepository;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Hash;
    use Throwable;

    class AuthController
    {
        /*
        *   Register a new User.
        *   Before manual validation is not an administrator and it is not active
        */
        public function register(RegisterRequest $request, UserRepository $userRepository): ApiErrorResponse|ApiSuccessResponse
        {
            $userDTO = UserDTO::fromRequest($request);

            DB::beginTransaction();

            try {
                $userRepository->create($userDTO);

                DB::commit();

                return new ApiSuccessResponse(
                    [
                        'name' => $userDTO->name,
                        'email' => $userDTO->email,
                        'user_type' => UserTypeEnum::from($userDTO->userTypeId)->name,
                        'isActive' => $userDTO->isActive,
                    ],
                    "New user successfully created, need activated by admin for full features access", 201
                );

            } catch (Throwable $t) {
                DB::rollBack();

                return new ApiErrorResponse('Can\'t create new user', $t);
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
                return new ApiErrorResponse("User not found", null, 404);
            }

            if (Hash::check($identifiers['password'], $user->password) && ($user->is_active) && ($user->user_type_id === UserTypeEnum::admin)) {
                // Token validity time
                $expirationTime = now()->addMinutes(60);
                $token = $user->createToken(time(), ['*'], $expirationTime)->plainTextToken;

                return new ApiSuccessResponse([
                    "token" => $token,
                    'expiration_date' => $expirationTime->format('d-m-Y H:i:s')
                ],
                    "Logged in successfully, use your Bearer token to authenticate on protected endpoints", 200);
            }
            // TODO log identifiants rentrés
            return new ApiErrorResponse('Login failed, unauthorized', null, 401);
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
