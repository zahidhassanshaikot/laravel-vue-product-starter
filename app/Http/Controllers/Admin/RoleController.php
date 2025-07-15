<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RoleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Services\RoleService;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $role_service;
    public function __construct(RoleService $role_service)
    {
        $this->role_service = $role_service;
    }

    public function index(RoleDataTable $dataTable)
    {
        setPageMeta('Roles');
        return $dataTable->render('admin.roles.index');
    }

    public function create()
    {
        checkPermission('Add Role');
        setPageMeta('Create Role');
        $permissions = $this->role_service->getPermissions();

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        checkPermission('Add Role');

        try {
            $this->role_service->updateOrCreate($request->all());

            sendFlash('Successful created.');
            return redirect()->route('roles.index');
        } catch (\Exception $e) {
            sendFlash($e->getMessage(), 'error');
            return back();
        }
    }

    public function edit($id)
    {
        checkPermission('Edit Role');
        setPageMeta('Edit Role');

        $permissions = $this->role_service->getPermissions();
        $role            = Role::where('id', $id)->with('permissions')->first();
        $parents_id      = [];
        $role_permission = [];
        foreach ($role->permissions as $value) {
            array_push($role_permission, $value->id);
            array_push($parents_id, $value->parent_id);
        }
        return view('admin.roles.edit', compact('parents_id', 'role', 'permissions', 'role_permission'));
    }

    public function update(RoleRequest $request, $id)
    {
        checkPermission('Edit Role');

        try {
            $this->role_service->updateOrCreate($request->all(), $id);

            sendFlash('Successful updated.');
            return redirect()->route('roles.index');
        } catch (\Exception $e) {
            sendFlash($e->getMessage(), 'error');
            return back();
        }
    }

    public function destroy($id)
    {
        checkPermission('Delete Role');

        try {
            $this->role_service->delete($id);

            sendFlash('Successful deleted.');
            return back();
        } catch (\Exception $e) {
            sendFlash($e->getMessage(), 'error');
            return back();
        }
    }
}
