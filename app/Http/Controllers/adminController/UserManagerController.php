<?php

namespace App\Http\Controllers\adminController;

use Illuminate\Http\Request;
use App\Repository\UserEloquent;

class UserManagerController extends Controller
{
  protected $userRepository;

    public function __construct(UserEloquent $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        $users = $this->userRepository->getAllUsers();

        return response()->json([
            'status' => 200,
            'message' => 'Users retrieved successfully',
            'data' => $users
        ]);
    }

    public function getUserInfo($id)
    {
        $user = $this->userRepository->getUserById($id);

        return response()->json([
            'status' => 200,
            'message' => 'User retrieved successfully',
            'data' => $user
        ]);
    }

    public function createUser(Request $request)
    {
        $user = $this->userRepository->createUser($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'User created successfully',
            'data' => $user
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = $this->userRepository->updateUser($id, $request->all());

        return response()->json([
            'status' => 200,
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }

    public function deleteUser($id)
    {
        $this->userRepository->deleteUser($id);
        return response()->json([
            'status' => 200,
            'message' => 'User deleted successfully',
            'data' => null
        ]);
    }
}