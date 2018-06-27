<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'username' => 'required|string|between:2,255|unique:users,username,' .
                $this->input('id') . ',id',
            'gender' => 'required|required|boolean',
            'mobile'   => ['required', 'string', 'regex:/^0?(13|14|15|17|18)[0-9]{9}$/'],
            // 'remark'        => 'nullable|string|between:2,255',
        ];
    }

    protected function prepareForValidation() {

        $input = $this->all();
        if (isset($input['enabled']) && $input['enabled'] === 'on') {
            $input['enabled'] = 1;
        }
        if (!isset($input['enabled'])) {
            $input['enabled'] = 0;
        }

        $this->replace($input);


    }
}
