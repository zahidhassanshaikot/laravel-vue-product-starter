<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function __construct($disk = null)
    {
        $this->disk = $disk ?? config('filesystems.default');
    }

    public function uploadBase64File(Request $request, $field_name = null, $upload_path = null, $delete_path = null)
    {
        // Upload image
        if ($request->$field_name) {
            // Delete old file
            if ($delete_path) {
                $this->delete($delete_path);
            }
            // Upload new file
            return $this->uploadBase64($request->$field_name, $upload_path);
        }
    }

    public function uploadFile(Request $request, $field_name, $upload_path = null, $delete_path = null)
    {
        // Upload image
        if ($request->hasFile($field_name)) {
            // Delete old file
            if ($delete_path) {
                $this->delete($delete_path);
            }
            // Upload new file
            return $this->upload($request->file($field_name), $upload_path);
        }
    }

    public function upload($file, $path = 'uploads/others', $use_client_file_name = false)
    {
        $file_name = $use_client_file_name ?
            (pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $file->getClientOriginalExtension())
            : (time() . '_' . rand() . '_' . (auth()->id() ?? '') . '.' . $file->getClientOriginalExtension());
        $filename_dir = trim($path, "/") . "/" . $file_name;

        if ($use_client_file_name) {
            while (Storage::disk($this->disk)->exists($filename_dir)) {
                $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . rand((auth()->id ?? 1), ((auth()->id ?? 1) * 1024)) . '.' . $file->getClientOriginalExtension();
                $filename_dir = trim($path, "/") . "/" . $file_name;
            }
        }

        $path = Storage::disk($this->disk)->putFileAs('', $file, $filename_dir);

        return $filename_dir;
    }

    public function getFileSize($file)
    {
        return $file->getSize();
    }

    public function getFileName($file)
    {
        return $file->getClientOriginalName();
    }

    public function uploadBase64($file, $path = 'others')
    {
        if ($file) {
            $name = time() . Str::uuid() . '.png';
            $img = substr($file, strpos($file, ",") + 1);
            Storage::disk($this->disk)->put($path . '/' . $name, base64_decode($img));
            return $name;
        }
    }

    public function delete($path = '')
    {
        try {
            // Delete image form public directory
            Storage::disk(config('filesystems.default'))->delete($path);
        } catch (Exception $ex) {
            return null;
        }
    }
}
