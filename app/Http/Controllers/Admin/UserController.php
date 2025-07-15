<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;



class UserController extends Controller
{
    protected $userServices;
    protected $roleService;

    public function __construct(UserService $userServices,RoleService $roleService)
    {
        $this->userServices = $userServices;
        $this->roleService = $roleService;
    }

    /**
     * Define middleware for the controller.
     *
     * @return array
     */
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('List User'), only: ['index']),
            new Middleware(PermissionMiddleware::using('Add User'), only: ['create', 'store']),
            new Middleware(PermissionMiddleware::using('Edit User'), only: ['edit', 'update']),
            new Middleware(PermissionMiddleware::using('Delete User'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('Restore User'), only: ['restore']),
        ];
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
    public function create(): \Illuminate\View\View
    {
        $roles = $this->roleService->get();

        setPageMeta(__('Add User'));
        return view('admin.users.create', compact('roles'));
    }

    public function store(UserRequest $request) : \Illuminate\Http\RedirectResponse
    {
        try {
            $user = $this->userServices->createOrUpdate($request);
            sendFlash('Successfully created user', 'success');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            sendFlash($e->getMessage(), 'error');
            return back();
        }
    }

    public function edit(User $user) : \Illuminate\View\View
    {
        setPageMeta('Edit User');
        $roles = $this->roleService->get();
        return view('admin.users.edit', compact('user','roles'));
    }

    public function update(UserRequest $request, $id): RedirectResponse
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

    public function destroy($id) : RedirectResponse
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
    public function bulk_destroy(Request $request) : RedirectResponse
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
    public function restore($id) : RedirectResponse
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
