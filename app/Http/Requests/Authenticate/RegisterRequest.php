<?php

    namespace App\Http\Requests\Authenticate;

    use App\Enum\UserTypeEnum;
    use Error;
    use Illuminate\Contracts\Validation\ValidationRule;
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Validation\Rules\Enum;

    class RegisterRequest extends FormRequest
    {
        /**
         * Determine if the user is authorized to make this request.
         */
        public function authorize(): bool
        {
            return true;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array<string, ValidationRule|array|string>
         */
        public function rules(): array
        {
            return [
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string',
                'userType' => [
                    'numeric', new Enum(UserTypeEnum::class)
                ]
            ];
        }

        public function prepareForValidation(): void
        {

            try {
                $userTypeId = UserTypeEnum::{$this->request->get('userType')}->value;
                $this->merge([
                    'userType' => $userTypeId
                ]);
            } catch (Error $t) {
                $this->merge([
                    'userType' => null
                ]);

                Log::error('User type request error', [
                    'message' => $t->getMessage(),
                    'code' => $t->getCode(),
                    'trace' => $t->getTraceAsString()
                ]);
            }
        }

        /**
         * Specific message error
         */
        public function messages(): array
        {
            return [
                'userType.numeric' => 'UserType error, check your value'
            ];
        }
    }
