<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\RoleService;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userServices;
    protected $roleServices;

    public function __construct(UserService $userServices,RoleService $roleService)
    {
        $this->userServices = $userServices;
        $this->roleService = $roleService;

        $this->middleware(['permission:List User'])->only(['index']);
        $this->middleware(['permission:Add User'])->only(['create','store']);
        $this->middleware(['permission:Edit User'])->only(['edit','update']);
        $this->middleware(['permission:Delete User'])->only(['destroy']);
    }

    public function index(UserDataTable $dataTable)
    {
        setPageMeta('User List');

        return $dataTable->render('admin.users.index');
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        $roles = $this->roleService->get();

        setPageMeta(__('Add User'));
        return view('admin.users.create', compact('roles'));
    }

    public function store(UserRequest $request) // Use Request class
    {
        try {
            $this->userServices->createOrUpdate($request);

            sendFlash('Successfully created user', 'success');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            sendFlash($e->getMessage(), 'error');
            return back();
        }
    }

    public function edit(User $user)
    {
        setPageMeta('Edit User');
        $roles = $this->roleService->get();
        return view('admin.users.edit', compact('user','roles'));
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $this->userServices->createOrUpdate($request, $id);

            sendFlash('Successfully Updated');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            sendFlash($e->getMessage(), 'error');
            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $this->userServices->deleteForceDeleteModel($id);

            sendFlash(__('Successfully Deleted'));
            return back();
        } catch (\Exception $e) {
            sendFlash(__($e->getMessage()), 'error');
            return back();
        }
    }
    public function bulk_destroy(Request $request)
    {
        try {
            $userIds = explode(",", $request->id);
            if (count($userIds) > 0) {
                foreach ($userIds as $key => $userId) {
                    $this->userServices->deleteForceDeleteModel($userId);
                }

            }
            sendFlash(__('Successfully Deleted'));
            return back();
        } catch (\Exception $e) {
            sendFlash(__($e->getMessage()), 'error');
            return back();
        }
    }
    public function restore($id)
    {
        try {
            $this->userServices->restore($id);
            sendFlash(__('Successfully Restored'));
            return back();
        } catch (\Exception $e) {
            sendFlash(__($e->getMessage()), 'error');
            return back();
        }
    }

}
