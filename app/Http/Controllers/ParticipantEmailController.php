<?php

namespace App\Http\Controllers;

use App\Participant;
use Illuminate\Http\Request;

class ParticipantEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        $participant = Participant::find($request->input('pid'));
        if ($participant) {
            $participant->sendConfirmationEmail();
        }
    }
}
