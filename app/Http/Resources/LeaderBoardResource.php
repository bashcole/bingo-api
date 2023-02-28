<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class LeaderBoardResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = null;


    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'score' => $this->score,
            'name'  => $this->user->name,
        ];
    }
}
