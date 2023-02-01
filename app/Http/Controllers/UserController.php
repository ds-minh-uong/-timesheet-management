<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        $this->authorize('viewAny', Auth::user());
        $users = User::all();

        return view('manage-user', ['users' => $users]);
    }

    //update user's role
    public function update(User $user, ProfileUpdateRequest $request) {
        $req = $request->validated();
        User::find($user->id)->update([
            'role' => $req['role'],
        ]);
        return view('manage');
    }
    public function destroy(User $user)
    {
        $this->authorize('delete', Auth::user());
        $user->delete();
        return Redirect::route('manager');
    }
}
