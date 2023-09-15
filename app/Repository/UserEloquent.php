<?php

namespace App\Repository;

use App\Models\User;

class UserEloquent extends BaseEloquent
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserById($id)
    {
        return User::find($id);
    }

    public function createUser($data)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->save();

        return $user;
    }

    public function updateUser($id, $data)
    {
        $user = User::find($id);

        if (isset($data['name'])) {
            $user->name = $data['name'];
        }
        if (isset($data['email'])) {
            $user->email = $data['email'];
        }
        if (isset($data['role'])) {
            $user->role = $data['role'];
        }
        $user->save();

        return $user;
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return true;
        }
        
        return false;
    }
}
