<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Response;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply): Response
    {
        return response($reply->favorite());
    }

    public function destroy(Reply $reply): Response
    {
        return response($reply->unfavorite());
    }
}
