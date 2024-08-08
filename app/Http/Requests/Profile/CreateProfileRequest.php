<?php

    namespace App\Http\Requests\Profile;

    use App\Models\ProfileStatus;
    use Illuminate\Contracts\Validation\ValidationRule;
    use Illuminate\Foundation\Http\FormRequest;
    use App\Rules\EnumValue;

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
                    'required', new EnumValue(ProfileStatus::class)
                ],
            ];
        }
    }
