<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use zahidhassanshaikot\Settings\Models\Settings;

class SettingController extends Controller
{
    public function index()
    {
        checkPermission('Site Settings');
        setPageMeta('System Settings');
        return view('settings.index');
    }

    public function store(SettingRequest $request)
    {
        $datas = $request->except('_token', 'site_logo', 'wide_site_logo', 'site_favicon', 'default_logo');

        // Upload files
        $files = $request->only('site_logo', 'wide_site_logo', 'site_favicon', 'default_logo');
        $path = 'settings';
        foreach ($files as $key => $file) {
            $file_upload_service = new FileUploadService();
            $path_url = $file_upload_service->uploadFile($request, $key, $path, config("settings.{$key}"));

            $datas[$key] = $path_url;
        }

        // Save data
        foreach ($datas as $key => $value) {

            Settings::query()->updateOrCreate(['key' => $key], [
                'value' => $value
            ]);
        }

        return back()->with('success', 'Setting Successfully Updated.');
    }
}
