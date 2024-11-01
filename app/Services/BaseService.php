<?php

namespace App\Services;

use App\Services\Admin\Utility\AppTransUtility;
use App\Services\FileUploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

/**
 * BaseService
 *
 * Base service class providing common CRUD operations for models.
 *
 * @package App\Services
 */
class BaseService
{
    protected mixed $model;
    protected mixed $translationModel;
    protected mixed $fileUploadService;

    /**
     * Constructor to initialize the BaseService.
     *
     * @param Model $model The model instance to be used.
     * @return void
     */
    public function __construct(Model $model, Model $translationModel = null)
    {
        $this->model = $model;
        $this->translationModel = $translationModel;
        $this->fileUploadService = app(FileUploadService::class);
    }

    /**
     * Create or update a model instance.
     *
     * @param Request|array $data The data to create or update the model instance.
     * @param int|null $id The ID of the model instance to update (optional).
     * @return mixed The updated model instance.
     * @throws Throwable
     */
    public function createOrUpdate(Request|array $data, int $id = null): mixed
    {
        try {
            if ($id) {
                $data['updated_by'] = Auth::id();

                // Find the model instance by ID
                $findModel = $this->model->findOrFail($id);

                // Update the model instance with the provided data
                $findModel->update($data);

                // Refresh to get the updated data from the database
                return $findModel->refresh();
            } else {
                $data['created_by'] = Auth::id();

                return $this->model::query()
                    ->create($data);
            }
        } catch (Throwable $th) {
            report($th);
            throw $th;
        }
    }

    /**
     * Create or update a translation record.
     *
     * This method creates or updates a translation record in the database based on the provided data.
     *
     * @param array $transData
     * The first two elements of the array are used for querying existing records
     *
     * @return mixed Returns the created or updated translation record.
     * @throws Throwable
     */
    public function createOrUpdateTrans(array $transData): mixed
    {
        try {
            // Extract the keys needed for querying (assuming first two keys are used for querying)
            $queryableData = array_slice($transData, 0, 2);

            // Update or create translation
            return $this->translationModel->updateOrCreate(
                $queryableData,
                $transData
            );
        } catch (Throwable $th) {
            report($th);
            throw $th;
        }
    }

    /**
     * get
     *
     * @param mixed $id
     * @param mixed $with
     * @param mixed $limit
     * @param mixed $scope
     * @return mixed
     * @throws Throwable
     */
    public function get(mixed $id = null, mixed $with = [], mixed $limit = null, mixed $scope = [])
    {
        try {
            if ($id) {
                if (count($scope) > 0) {
                    $data = $this->model->with($with);
                    foreach ($scope as $key => $value) {
                        $data = $data->$value();
                    }
                    $data->find($id);
                } else {
                    $data = $this->model->with($with)->find($id);
                }

                return $data ? $data : false;
            } else {
                $data = $this->model->with($with);
                if (count($scope) > 0) {
                    foreach ($scope as $key => $value) {
                        $data = $data->$value();
                    }
                }
                return $data->limit($limit)->get();
            }
        } catch (Throwable $th) {
            report($th);
            throw $th;
        }
    }

    /**
     * Retrieve active model instances.
     *
     * @param int|null $id The ID of the model instance to retrieve.
     * @param array $with The relationships to eager load.
     * @param null $limit
     * @return mixed The retrieved model instance or collection.
     * @throws Throwable
     */
    public function getWithTrashed(mixed $id = null, array $with = [], $limit = null): mixed
    {
        try {
            if ($id) {
                $data = $this->model->with($with)->withTrashed()->find($id);
                return $data ? $data : false;
            } else {
                return $this->model->with($with)->limit($limit)->get();
            }
        } catch (Throwable $th) {
            report($th);
            throw $th;
        }
    }

    /**
     * getActiveData
     *
     * @param mixed|null $id
     * @param mixed|array $with
     * @return mixed
     * @throws Throwable
     */
    public function getActiveData(mixed $id = null, mixed $with = []): mixed
    {
        try {
            if ($id) {
                $data = $this->model->with($with)->active()->find($id);
                return $data ? $data : false;
            } else {
                return $this->model->with($with)->active()->get();
            }
        } catch (Throwable $th) {
            report($th);
            throw $th;
        }
    }

    /**
     * Delete a model instance by ID.
     *
     * @param int $id The ID of the model instance to delete.
     * @throws Throwable
     */
    public function delete(int $id)
    {
        try {
            $data = $this->model::findOrFail($id);
            return $data->delete();
        } catch (Throwable $th) {
            report($th);
            throw $th;
        }
    }

    /**
     * Delete a soft deleted model instance by ID.
     *
     * @param int $id The ID of the model instance to delete.
     * @return bool True if the deletion was successful, false otherwise.
     * @throws Throwable
     */
    public function deleteSoftDeleteModel(int $id): bool
    {
        try {
            $data = $this->model::withTrashed()->findOrFail($id);
            if ($data->trashed()) {
                return $data->forceDelete();
            } else {
                return $data->delete();
            }
        } catch (Throwable $th) {
            report($th);
            throw $th;
        }
    }

    /**
     * Force delete a soft deleted model instance by ID.
     *
     * @param int $id The ID of the model instance to force delete.
     * @return bool True if the deletion was successful, false otherwise.
     * @throws Throwable
     */
    public function deleteForceDeleteModel(int $id): bool
    {
        try {
            $data = $this->model::withTrashed()->findOrFail($id);
            return $data->forceDelete();
        } catch (Throwable $th) {
            report($th);
            throw $th;
        }
    }

    /**
     * Restore a soft deleted model instance by ID.
     *
     * @param int $id The ID of the model instance to restore.
     * @return bool True if the restoration was successful, false otherwise.
     * @throws Throwable
     */
    public function restore(int $id): bool
    {
        try {
            $data = $this->model::withTrashed()->findOrFail($id);
            return $data->restore();
        } catch (Throwable $th) {
            report($th);
            throw $th;
        }
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param string $name The method name.
     * @param array $arguments The method arguments.
     * @return void
     */
    public function __call(string $name, array $arguments)
    {
        $this->model->{$name}($arguments);
    }

    /**
     * @param null $id
     */
    public function findOrNew($id = null)
    {
        try {
            $model = new $this->model();

            if ($id) {
                $model = $this->model->find($id);
            }

            return $model;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
