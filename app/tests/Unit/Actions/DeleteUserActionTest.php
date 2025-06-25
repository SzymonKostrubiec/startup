<?php

namespace tests\Unit\Actions;

use App\Actions\DeleteUserAction;
use App\Models\User;
use App\Models\UserEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class DeleteUserActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_user_with_emails()
    {
        $user = User::factory()->create();
        $email = UserEmail::factory()->create(['user_id' => $user->id]);

        $action = new DeleteUserAction();
        $action->handle($user);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('user_emails', ['id' => $email->id]);
    }

    public function test_it_rolls_back_on_failure()
    {
        $user = User::factory()->create();
        UserEmail::factory()->create(['user_id' => $user->id]);

        $userMock = Mockery::mock(User::class)->makePartial();
        $userMock->shouldReceive('delete')->andThrow(new \Exception('Test error'));
        $this->app->instance(User::class, $userMock);

        $action = new DeleteUserAction();
        $action->handle($userMock);

        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}
