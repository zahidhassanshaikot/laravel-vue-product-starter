<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use zahidhassanshaikot\Settings\Models\Settings;

class SettingController extends Controller
{
    public function index()
    {
        checkPermission('Site Settings');
        setPageMeta(__('System Settings'));
        return view('admin.settings.index');
    }

    public function store(SettingRequest $request)
    {
        $data = $request->except('_token', 'site_logo', 'wide_site_logo', 'site_favicon', 'default_logo');

        $data = $this->handleFileUpload($request, $data);
        $this->saveSettings($data);
        Cache::forget('system_settings');

        return back()->with('success', __('Setting Successfully Updated.'));
    }

    private function saveSettings(array $data): void
    {
        foreach ($data as $key => $value) {

            $value = is_array($value) || is_object($value) ? json_encode($value) : $value;
            Settings::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }

    //   handle file upload
    private function handleFileUpload(Request $request, $data)

    {
        // Upload files
        $files = $request->only('site_logo', 'wide_site_logo', 'site_favicon', 'default_logo');
        $path = 'settings';

        if (!empty($files)) {
            foreach ($files as $key => $file) {
                $file_upload_service = new FileUploadService();
                $path_url = $file_upload_service->uploadFile($request, $key, $path, config("settings.{$key}"));

                $data[$key] = $path_url;
            }
        }
        return $data;
    }
}
