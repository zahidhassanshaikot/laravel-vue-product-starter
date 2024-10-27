<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Http\Request;

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

        return $dataTable->render('users.index');
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
        return view('users.create', compact('roles'));
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
        return view('users.edit', compact('user','roles'));
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
            $this->userServices->delete($id);

            sendFlash('Successfully Deleted');
            return back();
        } catch (\Exception $e) {
            sendFlash($e->getMessage(), 'error');
            return back();
        }
    }
}
