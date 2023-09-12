<?php

namespace App\Http\Controllers\userController;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        $user = User::find($request->user()->id);

        return response()->json([
          'status' => 'success',
          'message' => 'User data retrieved successfully.',
          'data' => $user
      ]);
    }

    public function updateProfile(Request $request)
    {
        $user = User::find($request->user()->id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User data updated successfully.',
            'data' => $user
        ]);
    }
}