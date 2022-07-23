<?php

namespace App\Actions;

use App\Member;
use App\Participant;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Exceptions\FailedRegistrationException;
use App\Services\EntranceRate;

class CreateParticipantAction
{
    public function handle($validated)
    {
        // dd($validated);
        $isMember = Member::where('staff_id', strtoupper($validated['staff_id']))->exists();
        Arr::add($validated, 'member', $isMember);

        DB::beginTransaction();

        $participant = Participant::create($validated);

        if (Arr::has($validated, 'dependant_name')) {
            $dependants = [];
            foreach ($validated['dependant_name'] as $key => $value) {
                if (isset($value)) { //check for existance of dependants
                    array_push($dependants, [
                        'name' => Str::title($value),
                        'relationship' => Str::title($validated['dependant_relationship'][$key]),
                        'age' => $validated['dependant_age'][$key],
                        'member' => $isMember,
                        'participant_id' => $participant->id,
                    ]);
                }
            }
            $participant->dependants()->createMany($dependants);
        }



        if ($participant) {
            DB::commit();
            return $participant;
        }

        DB::rollBack();

        return redirect()->to(URL::previous() . '#registration')->withErrors('Registration failed. Please contact admin for details.')->withInput();
    }
}