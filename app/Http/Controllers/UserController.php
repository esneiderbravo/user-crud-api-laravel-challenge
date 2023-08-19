<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    /**
     * Get user information
     *
     * @return Renderable
     */
    public function view(): Renderable
    {
        $userId = Auth::user()->id;
        $user = User::findOrFail($userId);
        return view('user.view', compact('user'));
    }

    /**
     * Edit user information
     *
     * @param UpdateUserProfileRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(UpdateUserProfileRequest $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $validatedData = $request->validated();
        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }
        $user->update($validatedData);

        return redirect()->route('home', ['page' => 1])->with('success', 'User information updated successfully.');
    }

}
