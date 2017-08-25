<?php

namespace Modules\ModuleControl\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'user_group_id' => 'required|exists:user_groups,id',
            'email' => sprintf('required|unique:users,email,%s,id', isset($this->user->id) ? $this->user->id : 0),
            'password' => sprintf('%smin:8', isset($this->user->id) ? null : 'required|'),
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
