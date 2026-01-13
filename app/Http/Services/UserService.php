<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\LeaveLimit;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;



class UserService
{
    public function getAllByDesc()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return response()->json([
            'users' => $users
        ], 200);
    }

    public function getUserById($id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'message' => 'id must be number'
            ]);
        }
        $user = User::findOrFail($id);
        return $user;
    }
    public function createUser(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Account created successfully!');
    }

    public function updateUser(UpdateUserRequest $request, $id)
    {
        if (!is_numeric($id)) {
            return response()->json(
                [
                    'message' => 'Id must be a number'
                ]
            );
        }
        $user = User::findOrFail($id);
        $user->fill($request->validated());
        $user->save();
        return response()->json(
            [
                'message' => 'Account successfully updated'
            ]
        );
    }

    public function updateUserStatus($id, $status)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => $status]);

        if ($status == 'confirmed') {
            $limit = LeaveLimit::firstOrCreate(['user_id' => $id]);
            return response()->json([
                'message' => $limit->wasRecentlyCreated ? "Created" : "Already exists"
            ]);
        }
        return response()->json(
            [
                'message' => "account declined successfully"
            ]
        );
    }

    public function updateUserActiveStatus($id, $status)
    {
        $user = User::findOrFail($id);
        $user->update(['active' => $status]);
        return response()->json(
            [
                'message' => "Selected account is now {$status}"
            ]
        );
    }
}
