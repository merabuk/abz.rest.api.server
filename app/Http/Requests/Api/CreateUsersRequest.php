<?php

namespace App\Http\Requests\Api;

use App\Rules\EmailRfc2822;
use App\Rules\PhoneNumberUa;

class CreateUsersRequest extends AbstractApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:60',
            'email' => ['required', 'string', 'min:2', 'max:100', new EmailRfc2822], //email:rfc
            'phone' => ['required', 'string', new PhoneNumberUa],
            'position_id' => 'required|integer|min:1|exists:positions,id',
            'photo' => 'sometimes|required|file|dimensions:min_width=70,min_height=70|mimes:jpeg,jpg|max:5120',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'photo.dimensions' => 'The photo dimensions must be greeter than 70x70px.',
        ];
    }
}
