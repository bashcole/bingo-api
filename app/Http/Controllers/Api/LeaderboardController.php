<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LeaderboardCollection;
use App\Models\Board;

class LeaderboardController extends Controller
{
    public function index(){
        $items = Board::with('user')
            ->orderBy('score', 'desc')
            ->whereNotNull('score')
            ->limit(10)
            ->get();

        return new LeaderBoardCollection($items);
    }
}
