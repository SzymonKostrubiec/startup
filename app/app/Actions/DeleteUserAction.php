<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class DeleteUserAction
{
    public function handle(User $user): void
    {
        try {
            DB::beginTransaction();
            $user->userEmails()->delete();
            $user->delete();
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }
    }
}
