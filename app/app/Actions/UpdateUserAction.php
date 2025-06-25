<?php

namespace App\Actions;

use App\Dtos\StoreOrUpdateUserDto;
use App\Mail\SendWelcomeMessage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

final class UpdateUserAction
{
    public function handle(User $user, StoreOrUpdateUserDto $dto): void
    {
        try {
            DB::beginTransaction();

            $user->update([
                'name' => $dto->name,
                'last_name' => $dto->lastName,
                'phone' => $dto->phone,
            ]);

            $user->userEmails()->delete();
            foreach ($dto->emails as $email) {
                $user->userEmails()->create(['email' => $email]);
            }

            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return;
        }

        $this->sendMail($user);
    }

    private function sendMail(User $user): void
    {
        foreach ($user->userEmails as $userEmail) {
            Mail::to($userEmail->email)->queue(new SendWelcomeMessage($user));
        }
    }
}
