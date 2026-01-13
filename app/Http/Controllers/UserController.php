<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Services\UserService;

class UserController extends Controller
{
    protected $UserService;

    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }

    public function AllUsers()
    {
        return $this->UserService->getAllByDesc();
    }

    public function UserById($id)
    {
        return $this->UserService->getUserById($id);
    }

    public function NewUser(StoreUserRequest $request)
    {
        return $this->UserService->createUser($request);
    }

    public function UpdateUser(UpdateUserRequest $request, $id)
    {
        return $this->UserService->updateUser($request, $id);
    }

    public function AcceptUser($id)
    {
        return $this->UserService->updateUserStatus($id ,'confirmed');
    }

    public function DeclineUser($id)
    {
        return $this->UserService->updateUserStatus($id, 'declined');
    }

    public function ActiveUser($id)
    {
        return $this->UserService->updateUserActiveStatus($id, 'active');
    }

    public function InactiveUser($id)
    {
        return $this->UserService->updateUserActiveStatus($id, 'inactive');
    }
}
