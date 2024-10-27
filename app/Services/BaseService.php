<?php

namespace App\Services;

use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Services\FileUploadService;

/**
 * BaseService
 */
class BaseService
{
    protected $model;
    protected $fileUploadService;

    /**
     * __construct
     *
     * @param  mixed $model
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->fileUploadService = app(FileUploadService::class);
    }

    /**
     * createOrUpdate
     *
     * @param  mixed $data
     * @param  mixed $id
     * @return void
     */
    public function createOrUpdate(array $data, $id = null)
    {
        try {
            if ($id) {
                $data['updated_by'] = Auth::id();
                return $this->model->findOrFail($id)->update($data);
            } else {
                $data['created_by'] = Auth::id();
                return $this->model::create($data);
            }
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * get
     *
     * @param  mixed $id
     * @param  mixed $with
     * @param  mixed $limit
     * @return void
     */
    public function get($id = null, $with = [], $limit = null)
    {
        try {
            if ($id) {
                $data = $this->model->with($with)->find($id);
                return $data ? $data : false;
            } else {
                return $this->model->with($with)->limit($limit)->get();
            }
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * getActiveData
     *
     * @param  mixed $id
     * @param  mixed $with
     * @return void
     */
    public function getActiveData($id = null, $with = [])
    {
        try {
            if ($id) {
                $data = $this->model->with($with)->active()->find($id);
                return $data ? $data : false;
            } else {
                return $this->model->with($with)->active()->get();
            }
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {
        try {
            $data = $this->model::findOrFail($id);
            return $data->delete();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function __call($name, $arguments)
    {
        $this->model->{$name}($arguments);
    }
}
