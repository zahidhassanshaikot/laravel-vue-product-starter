<?php

namespace App\Services;

use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleService extends BaseService
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }
    public function all()
    {
        return Role::latest()->get();
    }

    public function getPermissions()
    {
        return Permission::whereNull('parent_id')->with('childs')->get();
    }

    public function updateOrCreate($data_array, $id = null)
    {
        try {
            DB::beginTransaction();

            $data = collect($data_array)->only(['name'])->toArray();

            if($id) {
                $authUserRoleId = auth()->user()->roles->first()->id;
                if($authUserRoleId == $id) {
                    throw new \Exception('You can not update your own role');
                }
                $data['updated_by'] = auth()->id();
            } else {
                $data['created_by'] = auth()->id();
            }

            $role = Role::updateOrCreate(['id' => $id], $data);

            $role->syncPermissions($data_array['permissions']);

            DB::commit();

            return $role;
        } catch (\Throwable $th) {
            DB::rollback();

            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            Role::destroy($id);

            DB::commit();

            return;
        } catch (\Throwable $th) {
            DB::rollback();

            throw $th;
        }
    }
}
