<?php

namespace Tests\Feature;

use App\Models\Board;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Vinkla\Hashids\Facades\Hashids;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function testUserIsCreatedSuccessfully()
    {
        $payload = [
            'id'   => 1,
            'name' => "Sandbox"
        ];
        $this->json('post', route('auth'), $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure(
                [
                    'id',
                    'name'
                ]
            );
        $this->assertDatabaseHas('users', $payload);
    }

    public function testUnableToCreateUser()
    {
        $payload = [
            'id' => 1
        ];

        $this->json('post', route('auth'), $payload)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(function (AssertableJson $json) {
                $json->has('message')
                    ->has('errors', 1)
                    ->whereAllType([
                        'errors.name' => 'array',
                    ]);
            });
    }


    public function testBoardIsCreatedSuccessfully()
    {
        $user = User::factory()->create();

        $payload = [
            'user_id' => Hashids::encode(1),
            'cells'   => '[
        [1, false], [2, false], [3, false], [4, false], [5, false],
        [6, false], [7, false], [8, false], [9, false], [10, false],
        [11, false], [12, false], [13, "FREE"], [14, false], [15, false],
        [16, false], [17, false], [18, false], [19, false], [20, false],
        [21, false], [22, false], [23, false], [24, false], [25, false]
    ]'
        ];

        $response = $this->json('post', route('board.store'), $payload)
            ->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('boards', ['user_id' => 1, 'cells' => $payload['cells']]);
    }

    public function testUniquenessOfCallNextNumbers()
    {
        User::factory()->create();
        $board = Board::factory()->create();
        $id = Hashids::encode($board->id);
        $numbers = [];

        for ($i = 0; $i <= 100; $i++) {
            $number = $this->get(route('board.next', $id))->getOriginalContent();
            if ($number !== '') {
                $numbers[] = $number;
            }
        }

        $numbers = array_unique($numbers);
        $this->assertEquals(count($numbers), 100);
    }

    public function testLeaderboardList()
    {
        User::factory()->create();
        Board::factory(4)->scored()->create();
        $this->json('get',route('leaderboard'))
            ->assertJson(function (AssertableJson $json) {
                $json->has(4);
            });
    }

}
