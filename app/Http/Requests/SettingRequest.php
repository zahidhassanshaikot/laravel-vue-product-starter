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
            // General Settings
            'site_title'         => 'nullable|string',
            'contact_email'      => 'nullable|email',
            'contact_phone'      => 'nullable|string',
            'contact_address'    => 'nullable|string',
            'timezone'           => 'nullable|string',
            'currency_symbol'    => 'nullable|string',

            'site_logo'          => 'nullable|image|max:2048',
            'wide_site_logo'     => 'nullable|image|max:2048',
            'site_favicon'       => 'nullable|image|max:2048',
            'default_logo'       => 'nullable|image|max:2048',

            // Email Settings
            'mail_mailer'        => 'nullable|string',
            'mail_host'          => 'nullable|string',
            'mail_username'      => 'nullable|string',
            'mail_password'      => 'nullable|string',
            'mail_port'          => 'nullable|numeric',
            'mail_encryption'    => 'nullable|string',
            'mail_from_address'  => 'nullable|email',
            'mail_from_name'     => 'nullable|string',

            // Social Media Settings
            'facebook_url'       => 'nullable|url',
            'linkedin_url'       => 'nullable|url',
            'instagram_url'      => 'nullable|url',
            'twitter_url'        => 'nullable|url',
        ];
    }
}