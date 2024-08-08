<?php

    namespace App\Http\Requests\Profile;

    use App\Models\ProfileStatus;
    use App\Rules\EnumValue;
    use Illuminate\Contracts\Validation\ValidationRule;
    use Illuminate\Foundation\Http\FormRequest;

    class UpdateProfileRequest extends FormRequest
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
                'id' => 'required',
                'lastname' => 'required|string|max:255',
                'firstname' => 'required|string|max:255',
                "status" => [
                    'required', new EnumValue(ProfileStatus::class)
                ],
            ];
        }
    }
