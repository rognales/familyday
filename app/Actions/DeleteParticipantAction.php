<?php

namespace App\Actions;

use App\Participant;
use App\User;
use Illuminate\Support\Facades\DB;

class DeleteParticipantAction
{
    public function handle(array $validated, User $user)
    {
        // No need findOrFail since the checks already happen in form request
        $participant = Participant::find($validated['pid']);

        return DB::transaction(function () use ($participant, $user) {
            $participant->deleted_by = $user->id;
            $participant->save();
            $participant->delete();
            $participant->dependants()->delete();
        });
    }
}
