<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LeaderboardCollection extends ResourceCollection
{
    public static $wrap = null;

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $items = [];

        foreach ($this->collection as $item) {

            $items[] = [
                'name'  => $item->user->name,
                'score' => $item->score
            ];

        }

        return $items;
    }
}
