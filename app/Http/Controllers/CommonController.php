<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;

class CommonController extends Controller implements HasMiddleware
{
    use ApiReturnFormatTrait;

    /**
     * Define the middleware for the controller.
     *
     * @return array The middleware applied to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function loadModal($page_name, $param1 = null) :Factory|View
    {
        $otherLinks         = null;
        if ($param1) :
            $otherLinks     = explode('/', $param1);
        endif;
        return view("admin.modals.$page_name", compact('otherLinks'));
    }
    public function changeLanguage($lang){
        session()->put('locale', $lang);
        return redirect()->back();
    }

    /**
     * Change the status of a model.
     *
     * @param Request $request The HTTP request.
     * @param int $id The ID of the model.
     * @return JsonResponse A JSON response indicating the success or failure of the status change.
     */
    public function statusChange(Request $request, int $id): JsonResponse
    {
        $model = request()->model;
        $column = request()->column;
        $value = request()->value;

        if ($model::where('id', $id)->update([$column => $value])) {
            return response()->json(['success' => true, 'message' => __('Status changed successfully')]);
        } else {
            return response()->json(['success' => false, 'message' => __('Something went wrong')]);
        }
    }

    /**
     * Change the order of a model.
     *
     * @param Request $request The HTTP request.
     * @return JsonResponse A JSON response indicating the success or failure of the status change.
     */
    public function updateOrdering(Request $request): JsonResponse
    {
        $model = request()->model;

        if (count($request->data) > 0) {
            $updates = [];
            foreach ($request->data as $key => $id) {
                $updates[] = ['id' => $id, 'order' => $key + 1];
            }

            $model::query()->upsert($updates, ['id'], ['order']);

            return response()->json(['success' => true, 'message' => __('Order changed successfully')]);
        } else {
            return response()->json(['success' => false, 'message' => __('Something went wrong')]);
        }
    }

    /**
     * Change the bulk status of a model.
     *
     * @param Request $request The HTTP request.
     * @return JsonResponse A JSON response indicating the success or failure of the status change.
     */
    public function bulkStatusChange(Request $request): JsonResponse
    {
        try {
            $model = request()->model;
            $model_ids = $request->items ?: [];
            $status = $request->status;

            $model::whereIn('id', $model_ids)->update(['status' => $status]);

            return $this->responseWithSuccess('Successfully update status', []);
        } catch (\Exception $ex) {
            return $this->responseWithError($ex->getMessage(), [], 500);
        }
    }

    /**
     * Delete the bulk item of a model.
     *
     * @param Request $request The HTTP request.
     * @return RedirectResponse A JSON response indicating the success or failure of the delete items.
     */
    public function bulkDestroy(Request $request): RedirectResponse
    {
        try {
            logger('req',$request->all());
            $service = resolve($request->service_class_namespace);
            $method = $request->method_name ?: 'delete';
            $modelIds = explode(",", $request->id);

            logger('2',[
                'service' => $service,
                'method' => $method,
                'modelIds' => $modelIds
            ]);

            collect($modelIds)->each(function($modelId) use ($service, $method) {
                $service->$method($modelId);
            });

            sendFlash(__('Successfully Deleted'));
            return back();
        } catch (\Exception $e) {
            sendFlash(__($e->getMessage()), 'error');
            report($e);
            return back();
        }
    }

}
