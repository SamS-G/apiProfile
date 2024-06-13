<?php

    namespace App\Http\Requests;

    use HttpResponseException;
    use Illuminate\Contracts\Validation\ValidationRule;
    use Illuminate\Contracts\Validation\Validator;
    use Illuminate\Foundation\Http\FormRequest;

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
                'firstname' => 'required|string|max:255'
            ];
        }

        /**
         * @throws HttpResponseException
         */
        public function validationFailed(Validator $validator)
        {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Profile update failed',
                'errors' => $validator->errors()
            ]));
        }
    }
