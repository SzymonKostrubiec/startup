<?php

namespace App\Actions;

use App\Dtos\StoreOrUpdateUserDto;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class StoreUserAction
{
    public function handle(StoreOrUpdateUserDto $dto): void
    {
        try {
            DB::beginTransaction();

            $user = User::query()->create([
                'name' => $dto->name,
                'last_name' => $dto->lastName,
                'phone' => $dto->phone,
            ]);

            foreach ($dto->emails as $email) {
                $user->userEmails()->create([
                    'email' => $email,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return;
        }
    }
}
