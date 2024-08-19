<?php

    namespace App\Http\Requests\Profile;

    use Illuminate\Contracts\Validation\ValidationRule;

    class UpdateProfileRequest extends CreateProfileRequest
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
            $rules = parent::rules();

            $rules['id'] = 'required|exists:profiles,id';

            return $rules;
        }
    }
