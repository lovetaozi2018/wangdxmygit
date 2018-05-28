<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'user.realname' => 'required|string|between:2,255|unique:users,realname,' .
                $this->input('user_id') . ',id,' .
                'mobile,' . $this->input('user.mobile'),
            'user.gender'        => 'required|boolean',
            'user.mobile'        =>  ['nullable', 'string', 'regex:/^0?(13|14|15|17|18)[0-9]{9}$/'],
            'user.qq'         => 'nullable|integer|unique:users,qq,' .
                $this->input('user_id') . ',id',
            'user.wechat'         => 'nullable|string|unique:users,wechat,' .
                $this->input('user_id') . ',id',
            'student.class_id' => 'required',
            'student.duty' => 'nullable|string|between:2,255',
            'student.star' => 'nullable|string|between:2,255',
            'student.address' => 'nullable|string|between:2,255',
            'student.hobby' => 'nullable|string|between:2,255',
            'student.specialty' => 'nullable|string|between:2,255',
            'student.enabled' => 'required',
            // 'remark'        => 'nullable|string|between:2,255',
        ];
    }

    protected function prepareForValidation() {

        $input = $this->all();
        if (isset($input['student']['enabled']) && $input['student']['enabled'] === 'on') {
            $input['student']['enabled'] = 1;
        }
        if (!isset($input['student']['enabled'])) {
            $input['student']['enabled'] = 0;
        }

        $this->replace($input);


    }
}
