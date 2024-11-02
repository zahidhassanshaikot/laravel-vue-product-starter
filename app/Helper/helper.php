<?php

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

if (!function_exists('formateDate')) {
    /**
     * formateDate
     *
     * @param mixed $date
     * @param bool $withTime
     *
     * @return string
     */

    function formateDate($date, $withTime = false)
    {
        if ($withTime) {
            return \Carbon\Carbon::parse($date)->format('Y-m-d h:i a');
        }
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
    }
}


if (!function_exists('toggleClass')) {
    function toggleClass($disabled, $checked, $model, $column, $id, $route, $value, $altValue)
    {
        return '<input type="checkbox"' . $disabled . '
                 class="toggle-status-update"
                  id="' . $column . '_switch_' . $id . '"
                 switch="none"' . $checked . '
                 data-model="' . $model . '"
                 data-column="' . $column . '"
                 data-switch="success"
                 data-id="' . $id . '"
                 data-url="' . $route . '"
                 data-value="' . $value . '"
                 data-alt_value="' . $altValue . '
                 "/><label class="' . ($disabled == 'disabled' ? "not-allowed" : "") . '" for="' . $column . '_switch_' . $id . '" ></label>';
    }
}

if (!function_exists('formateDateFromCarbon')) {
    /**
     * custom_datetime
     *
     * @param string $format
     * @param mixed $datetime
     *
     * @return mixed
     */
    function formateDateFromCarbon($format = "Y-m-d g:i a", $datetime = null)
    {
        return Carbon::parse($datetime ?? now())->format($format);
    }
}


if (!function_exists('storagelink')) {
    /**
     * storageLink
     *
     * @param mixed $url
     * @param string $type
     *
     * @return string
     */

    function storagelink($url)
    {
        $defaultImage = 'settings/logo.png';
        if (config('settings.default_logo') && Storage::exists(config('settings.default_logo'))) {
            $defaultImage = config('settings.default_logo');
        }

        // dd(Storage::disk(config('filesystems.default'))->exists($url));

        if ($url && Storage::disk(config('filesystems.default'))->exists($url)) {
            return Storage::url($url);
        } else {
            return Storage::url($defaultImage);
        }
    }
}

if (!function_exists('downloadableLink')) {
    /**
     * downloadableLink
     */

    function downloadableLink($url, $disk = 'public')
    {
        return Storage::disk($disk)->url($url);
    }
}


if (!function_exists('deleteFileFromStorage')) {
    /**
     * deleteFileFromStorage
     */

    function deleteFileFromStorage($url, $disk = 'public')
    {
        if (Storage::disk($disk)->exists($url)) {
            Storage::disk($disk)->delete($url);
            return true;
        }

        return false;
    }
}

if (!function_exists('getStorageImage')) {

    function    getStorageImage($name, $is_user = false, $type ='default')
    {
        if ($name && Storage::disk(config('filesystems.default'))->exists($name)) {
            return Storage::disk(config('filesystems.default'))->url($name);
//            return app('url')->asset('storage/' . $name);
        }
        return $is_user ? getUserDefaultImage() : ($type == 'logo' ? getDefaultLogo() :($type == 'favicon'? getDefaultFavicon()  :($type == 'wide_logo' ? getDefaultWideLogo() : getDefaultImage())));
    }
}

if (!function_exists('getDefaultFavicon')){
    function getDefaultFavicon(){
        return asset('images/default/favicon.ico');
    }
}

function getDefaultWideLogo()
{
    return asset('images/default/default_logo.png');
}
function getDefaultLogo()
{
    return asset('images/default/logo-sm.png');
}
function getDefaultImage()
{
    return asset('images/default/default.png');
}
function getUserDefaultImage()
{
    return asset('images/default/user_default.png');
}

if (!function_exists('getRandomNumber')) {
    /**
     * getRandomNumber
     *
     * @param int $length
     *
     * @return string
     */

    function getRandomNumber($length = 8)
    {
        $characters = '0123456789';
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $string;
    }
}


if (!function_exists('checkPermission')) {
    /**
     * checkPermission
     *
     * @param mixed $permissions
     *
     * @return void
     */

    function checkPermission($permissions)
    {
        if (!auth()->user()->can($permissions)) {
            abort(403);
        }
    }
}


if (!function_exists('prefixGenerator')) {
    /**
     * prefixGenerator
     *
     * @param Model $model
     * @param string $prefix
     *
     * @return string
     */

    function prefixGenerator(Model $model, $prefix = 'ZHS-')
    {
        $countNumber = $model::count();
        return $prefix . sprintf('%06d', $countNumber + 1);
    }
}


if (!function_exists('getToday')) {
    /**
     * getToday
     *
     * @return mixed
     */

    function getToday()
    {
        return \Carbon\Carbon::parse(now())->format('Y-m-d');
    }
}


if (!function_exists('sendFlash')) {
    /**
     * sendFlash
     *
     * @param mixed $message
     * @param string $type
     *
     * @return void
     */

    function sendFlash($message, $type = 'success')
    {
        session()->flash($type, $message);
//        session()->put('toast_message', $message);
//        session()->put('toast_level', $type);
    }
}

if (!function_exists('systemSettings')) {
    /**
     * systemSettings
     *
     * @param string $columnName
     * @param string $configName
     *
     * @return string
     */
    function systemSettings($columnName = '', $configName = "settings")
    {
        return config($configName . '.' . $columnName);
    }
}

if (!function_exists('getPageMeta')) {
    /**
     * get_page_meta
     *
     * @param string $metaName
     *
     * @return mixed
     */
    function getPageMeta($metaName = "title", $default = "")
    {
        if (session()->has('page_meta_' . $metaName)) {
            $title = session()->get("page_meta_" . $metaName);
//            session()->forget("page_meta_" . $metaName);
            return $title ?? $default;
        }
        return $default;
    }
}


if (!function_exists('setPageMeta')) {
    /**
     * set_page_meta
     *
     * @param null $content
     * @param string $metaName
     *
     * @return void
     */
    function setPageMeta($content = null, $metaName = "title")
    {
        if ($metaName == 'title')
            session()->put('page_meta_header', $content);
        session()->put('page_meta_' . $metaName, $content);
    }
}


if (!function_exists('apiJsonResponse')) {
    /**
     * send api response
     *
     * @param string $status
     * @param array|null $data
     * @param string $message
     * @param integer $statusCode
     * @return response
     */
    function apiJsonResponse($status = 'success', $data = null, $message = '', $statusCode = 200)
    {
        return response()
            ->json([
                'status' => $status,
                'data' => $data ?? [],
                'message' => $message
            ], $statusCode);
    }
}


if (!function_exists('apiValidation')) {
    /**
     * validate api request
     *
     * @param Request $request
     * @param array $rule
     * @param array $attributes
     * @return void
     */
    function apiValidation(Request $request, $rule = [], $attributes = [])
    {
        $validator = Validator::make($request->all(), $rule, $attributes);
        if ($validator->fails()) {
            return apiJsonResponse('error', $validator->errors(), __('validation.default_message'), 422);
        } else {
            return null;
        }
    }
}


if (!function_exists('log_error')) {

    /**
     * Log error
     *
     * @param \Exception $e
     * @return void
     */
    function log_error(\Exception $e)
    {
        Log::error($e->getMessage());
    }
}

if (!function_exists('something_wrong_flash')) {

    /**
     * send flash message when error happened
     *
     * @param string|null $message
     * @return void
     */
    function something_wrong_flash($message = null)
    {
        Session::flash('error', $message ?? 'Something wrong!');
    }
}

if (!function_exists('all_timezones')) {
    function all_timezones()
    {
        if (Cache::has('all_timezones')) {
            $timezones = Cache::get('all_timezones');
        } else {
            Cache::put('all_timezones', config('app_custom_config.timezone'), \Carbon\Carbon::now()->addMonth(1));
            $timezones = Cache::get('all_timezones');
        }
        return $timezones ?? [];
    }
}

if (!function_exists('isActiveRoute')) {
    /**
     * isActiveRoute
     *
     * @return mixed
     */

    function isActiveRoute($parentRoute = false)
    {
        if (!$parentRoute) {
            return '';
        }

        if(is_array($parentRoute)) {
            foreach($parentRoute as $route) {
                if(Route::is($route . '.index') || Route::is($route . '.create') || Route::is($route . '.edit')) {
                    return 'mm-active';
                }
            }
            return '';
        } else {
            $status = Route::is($parentRoute . '.index') || Route::is($parentRoute . '.create') || Route::is($parentRoute . '.edit');
            if($status) {
                return 'mm-active';
            }
            return '';
        }
    }
}
