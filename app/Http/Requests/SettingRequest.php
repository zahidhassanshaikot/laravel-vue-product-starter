<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'site_title'        => 'required|string',
            'timezone'          => 'nullable',
            'site_logo'         => 'nullable|image|max:2048',
            'wide_site_logo'    => 'nullable|image|max:2048',
            'site_favicon'      => 'nullable|image|max:2048',
            'default_logo'      => 'nullable|image|max:2048',
        ];
    }
}
