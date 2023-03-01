<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Http\Request;

class BoardController extends Controller
{

    public function store(Request $request)
    {
        $board = new Board();
        $board->cells = $request->input('cells');
        $board->user_id = Hashids::decode($request->input('user_id'))[0];
        $board->roulette = implode(',', range(1, 100));
        $board->save();

        return response([
            "id" => Hashids::encode($board->id)
        ], 201);
    }

    public function show(Board $board)
    {

        if (empty($board)) {
            return [
                'cells' => "[
                    [null, false], [null, true], [null, false], [null, false], [null, false],
                    [null, false], [null, false], [null, false], [null, false], [null, false],
                    [null, false], [null, false], [null, false], [null, false], [null, false],
                    [null, false], [null, false], [null, false], [null, false], [null, false],
                    [null, false], [null, false], [null, false], [null, false], [null, false]
                ]"
            ];
        }

        return [
            'score' => $board->score,
            'type'  => $board->type,
            'cells' => $board->cells,
        ];

    }

    public function update(Board $board, Request $request)
    {
        if ($request->has('cells')) {
            $board->cells = $request->input('cells');
        }

        if ($request->has('type')) {
            $board->type = $request->input('type');
        }
        $board->save();
    }

    public function over(Board $board, Request $request)
    {
        $board->score = abs(100 - (100 - count($board->roulette)));
        $board->type = 'finished';
        $board->save();

        return [
            "score" => $board->score
        ];
    }

    public function next(Board $board)
    {
        $roulette = collect($board->roulette);

        $randomKey = rand(0, $roulette->count() - 1);
        $nextNumber = $board->roulette[$randomKey];
        $roulette->forget($randomKey);
        $board->roulette = $roulette->implode(',');
        if ($board->type === 'new') {
            $board->type = 'in_progress';
        }
        $board->save();

        return $nextNumber;
    }
}
