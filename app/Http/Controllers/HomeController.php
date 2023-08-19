<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param $page
     * @return Renderable
     */
    public function index($page): Renderable
    {
        $totalPages = 0;
        $results = [];
        $response = Http::get(config('app.constants.characterUrl') . '?page=' . $page);
        if ($response) {
            $totalPages = $response['info']['pages'];
            $results = $response['results'];
        }
        $nextPage = $page < $totalPages ? $page + 1 : null;
        $prevPage = $page > 0 ? $page - 1 : null;
        $results = (new UserFavoriteController())->searchFavorites($results);
        return view(
            'home',
            [
            'page' => $page,
            'nextPage' => $nextPage,
            'prevPage' => $prevPage,
            'results' => $results,
            ]
        );
    }
}
