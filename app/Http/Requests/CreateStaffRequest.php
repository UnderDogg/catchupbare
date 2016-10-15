<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateStaffRequest extends Request {

    /**
     * Determine if the staff is authorized to make this request.
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
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|unique:staff',
            'username' => 'required|unique:staff',
            'password' => 'required|confirmed',
        ];
    }

}
