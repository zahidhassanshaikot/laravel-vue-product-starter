<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
//    protected $fileUploadService;

    public function __construct(User $model)
    {
        parent::__construct($model);
//        $this->fileUploadService = $fileUploadService;
    }
    public function createOrUpdate($request, $id = null)
    {
        $data           = $request->all();
        if ($id) {
            // Update
            $user           = $this->get($id);

            // Password
            if (isset($data['password']) && $data['password']) {
                $user->password = Hash::make($data['password']);
            }

            // Avatar
            if (isset($data['avatar']) && $data['avatar'] != null) {
                $user->avatar = $this->fileUploadService->uploadFile($request,'avatar',User::FILE_STORE_PATH,$user->avatar);
            }

            $user->name     = $data['name'];
            $user->email    = $data['email'];
            $user->phone    = $data['phone'];
            if(auth()->user()->id != $id){
                $user->type     = $data['type'];
            }
            $user->status   = $data['status'];
            $user->updated_by = Auth::id();

            // Update user
            $user->save();
            // Give user role
            if(auth()->user()->id != $id) {
                $user->syncRoles($data['role']);
            }
            return $user;
        } else {
            // Create
            $data['password']        = Hash::make($data['password']);
            if (isset($data['avatar']) && $data['avatar'] != null) {
                $data['avatar']      = $this->fileUploadService->uploadFile($request,'avatar',User::FILE_STORE_PATH,);
            }
            $data['created_by'] = Auth::id();
            // Store user
            $user                       = $this->model::create($data);

            // Give user role
            return $user->syncRoles($data['role']);
        }
    }

}
