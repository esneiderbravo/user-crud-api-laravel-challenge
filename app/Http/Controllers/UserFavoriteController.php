<?php

namespace App\Http\Controllers;

use App\Models\UserFavorite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFavoriteController extends Controller
{
    /**
     * Create user favorite.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function post(Request $request): RedirectResponse
    {
        $userId = $request->user_id;
        $refApi = $request->ref_api;

        $existingFavorite = UserFavorite::where('user_id', $userId)->where('ref_api', $refApi)->first();

        if (!$existingFavorite) {
            UserFavorite::create([
                'user_id' => $userId,
                'ref_api' => $refApi,
            ]);
            $message = 'Character added to your favorites with success!';
        } else {
            $message = 'Character is already in your favorites!';
        }

        return back()->with('success', $message);
    }



    /**
     * Delete user favorite.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        $userId = $request->user_id;
        $refApi = $request->ref_api;

        $userFavoriteItem = UserFavorite::where('user_id', $userId)
            ->where('ref_api', $refApi)
            ->first();

        if ($userFavoriteItem) {
            $userFavoriteItem->delete();
            $message = 'Character removed from your favorites with success!';
        } else {
            $message = 'Character is not in your favorites!';
        }

        return back()->with('success', $message);
    }

    /**
     * Search favorite characters.
     *
     * @param $charactersList
     * @return mixed
     */
    public function searchFavorites($charactersList): mixed
    {
        foreach ($charactersList as &$character) {
            $userId = Auth::user()->id;
            $isFavorite = UserFavorite::where('user_id', $userId)->where('ref_api', $character['id'])->first();
            $character['favorite'] = (bool)$isFavorite;
        }
        return $charactersList;
    }

}
