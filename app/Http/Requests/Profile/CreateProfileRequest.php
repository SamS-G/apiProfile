<?php

    namespace App\Http\Requests\Profile;

    use App\Enum\ProfileStatusEnum;
    use App\Enum\UserTypeEnum;
    use Error;
    use Illuminate\Contracts\Validation\ValidationRule;
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Validation\Rules\Enum;

    class CreateProfileRequest extends FormRequest
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
                'lastname' => 'required|string|max:255',
                'firstname' => 'required|string|max:255',
                "status" => [
                    [
                        'numeric', new Enum(ProfileStatusEnum::class)
                    ]
                ],
            ];
        }
        public function prepareForValidation(): void
        {
            try {
                $status = ProfileStatusEnum::{$this->request->get('status')}->value;
                $this->merge([
                    'status' => $status
                ]);
            } catch (Error $t) {
                $this->merge([
                    'status' => null
                ]);

                Log::error('Profile status request error', [
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
                'status.numeric' => 'Profile status error, check your value'
            ];
        }
    }
